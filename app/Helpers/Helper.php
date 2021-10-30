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
    public static function insertIfNameDoesntExist($valueToCheck, $objectToCheck, $objectToAppendValue){

        $modelName = get_class($objectToCheck);
        // $relation = strtolower( last( explode('/', $modelName) ) ); Od "App\Models\City" dobijamo "city"
        $databaseValue = $modelName::where('name', $valueToCheck)->first();

        if($databaseValue){
            //Iz nekog razloga ne radi $objectToAppendValue->$relation()->associate($databaseValue): Call to undefined method App\Models\Client::app\models\city() iako postoji ta relacija(metod) unutar klase
            //Hardcodovanjem npr. city() Laravel sam prepozna relaciju koju treba da poveže :\
            $objectToAppendValue->city()->associate($databaseValue);
        }
        else{
            $newInsert = new $modelName();
            $newInsert->name = $valueToCheck;
            try{
                $newInsert->save();
                $objectToAppendValue->city()->associate($newInsert);
            }
            catch (\PDOException $e){
                DB::rollBack();
                return redirect()->back()->with('error', 'Došlo je do greške, molimo Vas pokušajte kasnije');
            }
        }

    }
}
