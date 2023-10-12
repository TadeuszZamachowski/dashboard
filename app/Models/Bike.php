<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BikesDashboardOrder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bike extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'rack',
        'code',
        'name',
        'status',
        'location',
        'order_id'
    ];
    
    public function bikesDashboardOrder(): HasMany
    {
        return $this->hasMany(BikesDashboardOrder::class);
    }
}
