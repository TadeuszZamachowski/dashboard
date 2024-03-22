<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class BikesCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'bike_id',
        'work',
        'rust',
        'brakes',
        'wheels',
        'chain',
        'notes'
    ];

    public function bike(): BelongsTo
    {
        return $this->belongsTo('App\Models\Bike','id', 'bike_id');
    }
}
