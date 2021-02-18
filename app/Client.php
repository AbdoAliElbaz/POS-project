<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class Client extends User
{
    // use SoftDeletes;
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    public function setPasswordAttribute($plainPassword)
    {
        $this->attributes['password'] = Hash::make($plainPassword);
    }
}
