<?php

namespace App\Helpers;

class Helper {

    public static function countDebt($client){

        $invoiceDebt = 0;
        $totalDebt = 0;
        $payed = 0;
        foreach($client->invoices as $invoice){
            foreach($invoice->payments as $payment){
                $payed += $payment->amount;
            }
            foreach ($invoice->items as $item){
                $invoiceDebt += $item->quantity * $item->price;
            }
            $totalDebt += $invoiceDebt - $payed;
        }
        return $totalDebt;
    }
}
