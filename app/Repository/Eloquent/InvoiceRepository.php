<?php

namespace App\Repository\Eloquent;

use App\Models\Invoice;
use App\Models\InvoiceStatus;
use App\Repository\InvoiceRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

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

    public function checkIfOverdue(Collection $invoices)
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
}
