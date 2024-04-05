<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'created_by',
        'type',
        'evaluable',
        'points',
        'question',
        'body_json',
        'input_json',
        'answer_json',
        'resources_json',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'created_by' => 'integer',
        'type' => 'integer',
        'evaluable' => 'boolean',
        'points' => 'integer',
        'question' => 'string',
        'body_json' => 'array',
        'input_json' => 'array',
        'answer_json' => 'array',
        'resources_json' => 'array',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
