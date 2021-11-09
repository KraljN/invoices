<?php

namespace App\Repository;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface InvoiceClientRepositoryInterface{

    public function update( Model $model, array $payload): bool;

    //Placena kolicina za odredjenu fakturu
    public function countPayedInvoiceAmount( Invoice $invoice): float;

    //Ukupna suma na jednoj fakturi
    public function countInvoiceDebt( Invoice $invoice): float;

    public function getClients(): Collection;

    public function insertIfNameDoesntExist($valueToCheck, $objectToCheck, $relation);

}
