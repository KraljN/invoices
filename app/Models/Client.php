<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
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
