<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdvType extends Model
{
    public function invoiceItems(){

        return $this->hasMany(InvoiceItem::class);

    }
}
