<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = ['client_name', 'vat', 'bank_account_number', 'address', 'registration_number', 'email', 'zip', 'updated_at'];

    public function country(){

        return $this->belongsTo(Country::class);

    }
    public function city()
    {

        return $this->belongsTo(City::class);

    }
    public function user(){

        return $this->belongsTo(User::class);

    }
    public function invoices(){

        return $this->hasMany(Invoice::class);

    }
}
