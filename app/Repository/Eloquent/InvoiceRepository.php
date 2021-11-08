<?php

namespace App\Repository\Eloquent;

use App\Models\Invoice;
use App\Models\InvoiceStatus;
use App\Repository\InvoiceRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Collection;

class InvoiceRepository extends BaseRepository implements InvoiceRepositoryInterface {

    public function __construct(Invoice $model)
    {
        parent::__construct($model);
    }

    function countDebt(Model $model): float
    {
        $totalDebt = 0;
        $payed = $this->countPayedInvoiceAmount($model);
        $invoiceDebt =  $this->countInvoiceDebt($model);
        $totalDebt = $invoiceDebt - $payed;

        return $totalDebt;
    }

    public function checkIfOverdue(EloquentCollection $invoices)
    {
        foreach($invoices as $invoice){
            $endDate = Carbon::make($invoice->end_date);
            //Ovu funkciju cemo koristiti vise puta mozda
            if(now()->gt($endDate)){
                $status = InvoiceStatus::find(Config::get('constants.invoice_status.overdue'));
                $invoice->invoiceStatus()->associate($status);
                $invoice->save();
            }
        }
    }

    public function getInvoicesStatuses(): Collection
    {
        return InvoiceStatus::all();
    }

    public function getInvoices(): Collection
    {
        $invoices = Invoice::with(['client', 'payments', 'items', 'invoiceStatus'])
            ->where('user_id', Auth::id());
        if (request()->query('status') > '0') {
            $invoices->whereHas('invoiceStatus', function (Builder $query) {
                $query->where('id', request()->query('status'));
            });
        }
        if(request()->query('date')){
            $invoices->where('date_created', request()->query('date'));
        }

        if(request()->query('name')){
            $invoices->whereHas('client', function (Builder $query) {
                $query->where('client_name', 'like', '%' .  request()->query('name') . "%");
            });
        }
        return $invoices->get();
    }
}
