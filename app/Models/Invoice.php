<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function invoiceStatus(){

        return $this->belongsTo(InvoiceStatus::class);

    }
    public function client(){

        return $this->belongsTo(Client::class);

    }
    public function user(){

        return $this->belongsTo(User::class);

    }
    public function payments(){

        return $this->hasMany(Payment::class);
        
    }
}
