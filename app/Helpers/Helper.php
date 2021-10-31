<?php

namespace App\Helpers;

use App\Http\Requests\ClientRequest;
use App\Models\City;
use App\Models\Client;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public static function removeFromAssociativeArray($array, array $whatToRemove){

        return array_diff_key($array, array_flip($whatToRemove));

    }

    public static function fillClientValues(ClientRequest $request, Client $client, $outputMessage){
        DB::beginTransaction();

        $client =  self::insertIfNameDoesntExist($request->country, new Country(), $client->country());
        $client = self::insertIfNameDoesntExist($request->city, new City(), $client->city());

        $client->user()->associate(Auth::user());
        $client->vat = $request->vat;
        $client->bank_account_number = $request->bank_account_number;
        $client->address = $request->address;
        $client->registration_number = $request->registration_number;
        $client->email = $request->email;
        $client->client_name = $request->client_name;
        $client->zip = $request->zip;


        try{
            $client->save();
            DB::commit();
            return  redirect()->back()->with('success', $outputMessage);
        }
        catch (\PDOException $e){
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Došlo je do greške. Molimo pokušajte kasnije.');
        }
    }
}
