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

      public function bikes(): BelongsTo
    {
        return $this->belongsTo(Bike::class);
    }

    public function dashboardOrders(): BelongsTo
    {
        return $this->belongsTo(DashboardOrder::class);
    }
}
