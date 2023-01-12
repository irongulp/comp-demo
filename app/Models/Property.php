<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;
    protected $casts = [
        'live'    => 'bool'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'organisation',
        'property_type',
        'parent_property_id',
        'uprn',
        'address',
        'town',
        'postcode',
        'live'
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(
            'App\models\Property',
            'parent_property_id'
        );
    }

    public function properties(): HasMany
    {
        return $this->hasMany(
            'App\models\Property',
            'parent_property_id'
        );
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(
            'App\Models\Certificate',
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
