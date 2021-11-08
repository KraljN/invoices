<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;

use Illuminate\Support\Collection;

interface InvoiceRepositoryInterface{

    public function checkIfOverdue( EloquentCollection $invoices );

    public function getInvoicesStatuses(): Collection;

    public function getInvoices(): Collection;


}
