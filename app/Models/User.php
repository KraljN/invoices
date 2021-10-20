<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function country(){

        return $this->belongsTo(Country::class);

    }
    public function city()
    {

        return $this->belongsTo(City::class);

    }
    public function clients(){

        return $this->hasMany(Client::class);

    }
    public function invoices(){

        return $this->hasMany(Invoice::class);

    }
}
