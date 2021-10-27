<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
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
