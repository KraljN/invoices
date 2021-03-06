<?php

namespace App\Repository\Eloquent;

use App\Models\City;
use App\Models\Client;
use App\Models\Country;
use App\Models\Invoice;
use App\Repository\InvoiceClientRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


abstract class InvoiceClientRepository extends BaseRepository implements InvoiceClientRepositoryInterface {

    abstract function countDebt(Model $model): float;

    public function update(Model $model, array $payload): bool
    {
        DB::beginTransaction();
        $model =  $this->insertIfNameDoesntExist($payload['country'], new Country(), $model->country());
        $model = $this->insertIfNameDoesntExist($payload['city'], new City(), $model->city());
        try{
            $model->update($payload);
            DB::commit();
            return true;
        }
        catch(\PDOException $ex){
            DB::rollBack();
            return false;
        }
    }

    public function countInvoiceDebt(Invoice $invoice): float
    {
        $invoiceDebt = 0;
        foreach ($invoice->items as $item){
            $invoiceDebt += $item->quantity * $item->price;
        }
        return $invoiceDebt;
    }

    public function countPayedInvoiceAmount(Invoice $invoice): float
    {
        $payed = 0;
        foreach($invoice->payments as $payment){
            $payed += $payment->amount;
        }
        return $payed;
    }
    public function insertIfNameDoesntExist($valueToCheck, $objectToCheck, $relation){

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
                return redirect()->back()->with('error', 'Do??lo je do gre??ke, molimo Vas poku??ajte kasnije');
            }
        }

    }

    public function getClients(): Collection
    {
        return Client::with(['country', 'city', 'invoices', 'invoices.payments', 'invoices.items'])->where('user_id', Auth::id())->get();
    }

}
