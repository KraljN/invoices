<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = ['invoice_name', 'date_created'];

    public function invoiceStatus(){

        return $this->belongsTo(InvoiceStatus::class, 'status_id');

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
    public function items(){

        return $this->hasMany(InvoiceItem::class);

    }
}
