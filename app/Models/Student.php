<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Student extends Model implements Authenticatable
{
    use AuthenticatableTrait;

    public function assigned_tests() {
        return $this->hasMany(Test::class, 'assigned_tests');
    }
}
