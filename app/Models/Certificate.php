<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificate extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stream_name',
        'property_id',
        'issue_date',
        'next_due_date'
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(
            'App\models\Property',
            'property_id'
        );
    }

    public function notes(): MorphMany
    {
        return $this->MorphMany(
            'App\Models\Note',
            'notable',
            'model_type',
            'model_id'
        );
    }
}
