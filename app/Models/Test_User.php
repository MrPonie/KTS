<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test_User extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'user_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'test_id' => 'integer',
        'user_id' => 'integer',
    ];
}
