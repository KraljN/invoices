<?php

namespace App\Repository;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface{

    public function  create( array $payload ): bool;

    public function update( Model $model, array$payload): bool;

    public function deleteById( int $id ): bool;

    public function countDebt( Model $model ): float;

    //Placena kolicina za odredjenu fakturu
    public function countPayedInvoiceAmount( Invoice $invoice): float;

    //Ukupna suma na jednoj fakturi
    public function countInvoiceDebt( Invoice $invoice): float;
}
