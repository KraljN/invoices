<?php

namespace App\Repository\Eloquent;

use App\Models\City;
use App\Models\Client;
use App\Models\Country;
use App\Models\Invoice;
use App\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository implements BaseRepositoryInterface{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create($payload): bool
    {
        DB::beginTransaction();
        $this->model =  $this->insertIfNameDoesntExist($payload['country'], new Country(), $this->model->country());
        $this->model = $this->insertIfNameDoesntExist($payload['city'], new City(), $this->model->city());
        $this->model->user()->associate(Auth::user());

        try{
            $this->model->fill($payload);
            $this->model->save();
            DB::commit();
            return true;
        }
        catch (\PDOException $ex){
            DB::rollBack();
            return false;
        }
    }

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

    public function deleteById(int $id): bool
    {
        try{
            $this->model::find($id)->delete();
            return true;
        }
        catch(\PDOException $ex){
            return false;
        }
    }

     //Metodi koji koriste i ClientController i InvoicesController

     abstract function countDebt(Model $model): float;

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
                return redirect()->back()->with('error', 'Došlo je do greške, molimo Vas pokušajte kasnije');
            }
        }

    }

    public function getClients(): Collection
    {
        return Client::with(['country', 'city', 'invoices', 'invoices.payments', 'invoices.items'])->where('user_id', Auth::id())->get();
    }

}
