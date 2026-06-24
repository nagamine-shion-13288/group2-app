<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'login_id', 'password_hash', 'name', 'address', 'user_phone'
    ];
}