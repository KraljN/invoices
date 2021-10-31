<?php

namespace App\Helpers;

use App\Models\City;
use App\Models\Country;
use Illuminate\Support\Facades\DB;

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
    public static function insertIfNameDoesntExist($valueToCheck, $objectToCheck, $relation){

        $modelName = get_class($objectToCheck);
        $objectToAppendValue = $relation->getChild();
        $databaseValue = $modelName::where('name', $valueToCheck)->first();

        if($databaseValue){
            $relation->associate($databaseValue);
            return $objectToAppendValue;
        }
        else{
            $newInsert = new $modelName();
            $newInsert->name = $valueToCheck;
            try{
                $newInsert->save();
                $relation->associate($newInsert);
                return $objectToAppendValue;
            }
            catch (\PDOException $e){
                DB::rollBack();
                return redirect()->back()->with('error', 'Došlo je do greške, molimo Vas pokušajte kasnije');
            }
        }

    }
}
