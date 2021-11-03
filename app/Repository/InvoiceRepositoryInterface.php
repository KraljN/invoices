<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;

interface InvoiceRepositoryInterface{

    public function checkIfOverdue( Collection $invoices );

}
