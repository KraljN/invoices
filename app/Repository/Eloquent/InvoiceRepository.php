<?php

namespace App\Repository\Eloquent;

use App\Models\City;
use App\Models\Client;
use App\Models\Country;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceStatus;
use App\Models\PdvType;
use App\Repository\InvoiceRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class InvoiceRepository extends InvoiceClientRepository implements InvoiceRepositoryInterface {

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

    public function create($payload): bool
    {

        DB::beginTransaction();
        $status = InvoiceStatus::find(Config::get('constants.invoice_status.unpaid'));
        $client = Client::find($payload['client']);
        $this->model->user()->associate(Auth::user());
        $this->model->client()->associate($client);
        $this->model->invoiceStatus()->associate($status);
        $this->model->date_of_traffic = $payload['date_created'];
        $carbonDate = Carbon::make($payload['date_created']);
        $defaultEndDate = $carbonDate->addDays(10);
        $formatedDate = date("Y-m-d H:i:s", $defaultEndDate->getTimestamp());
        $this->model->end_date = $formatedDate;
        try{
            $this->model->fill($payload);
            $this->model->save();
            DB::commit();
            session()->put('insertedInvoiceId', $this->model->id);
            return true;
        }
        catch (\PDOException $ex){
            DB::rollBack();
            return false;
        }

    }

    public function getPdvTypes(): Collection
    {
        return PdvType::all();
    }

    public function getInvoiceItems($invoiceId): Collection
    {
        return InvoiceItem::with(['invoice', 'pdvType'])->where('invoice_id', $invoiceId)->get();
    }
}
