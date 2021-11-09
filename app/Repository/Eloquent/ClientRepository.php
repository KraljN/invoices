<?php

namespace App\Repository\Eloquent;

use App\Models\City;
use App\Models\Client;
use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    function create($payload): bool
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
}
