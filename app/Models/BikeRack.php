<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BikeRack extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'value',
        'bike_id'
    ];

    public function bike(): BelongsTo 
    {
        return $this->belongsTo('App\Models\Bike', 'bike_id', 'id');
    }
}
