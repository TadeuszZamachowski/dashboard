<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BikesDashboardOrder extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'bike_id',
        'order_id',
        'start_date',
        'end_date'
      ];

      public function bike(): BelongsTo
    {
        return $this->belongsTo('App\Models\Bike', 'bike_id', 'id');
    }
    public function dashboardOrder(): BelongsTo
    {
        return $this->belongsTo('App\Models\DashboardOrder', 'order_id', 'dashboard_order_id');
    }
}
