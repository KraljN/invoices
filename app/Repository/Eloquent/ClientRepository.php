<?php

namespace App\Repository\Eloquent;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;

class ClientRepository extends BaseRepository {

    public function __construct(Client $model)
    {
        parent::__construct($model);
    }

    function countDebt(Model $model): float
    {
        $totalDebt = 0;
        foreach($model->invoices as $invoice){
            $payed = self::countPayedInvoiceAmount($invoice);
            $invoiceDebt =  self::countInvoiceDebt($invoice);
            $totalDebt += $invoiceDebt - $payed;
        }
        return $totalDebt;
    }
}
