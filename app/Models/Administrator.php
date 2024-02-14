<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Administrator extends Model implements Authenticatable
{
    use AuthenticatableTrait;

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed'
    ];
}
