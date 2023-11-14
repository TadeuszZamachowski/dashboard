<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BikesDashboardOrder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bike extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'color',
        'type',
        'gear',
        'accessory',
        'code',
        'location',
        'rack',
        'state',
        'status',
        'helmet',
        'notes',
        'dashboard_order_id'
    ];
    
    public function dashboardOrder(): BelongsTo
    {
        return $this->belongsTo('App\Models\DashboardOrder','dashboard_order_id', 'dashboard_order_id');
    }

    public function rack(): BelongsTo
    {
        return $this->belongsTo('App\Models\BikeRack','id', 'bike_id');
    }
}
