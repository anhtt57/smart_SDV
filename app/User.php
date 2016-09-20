<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $fillable = [
        'first_name','last_name','email','password','full_name','gender','email','birthday','remember_token','phone_number','role','postal_code','address1','address2','created_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    const CRO = 0;
    const CRC = 1;
    const SMO = 2;
    protected $hidden = [
        'password', 'remember_token',
    ];
}
