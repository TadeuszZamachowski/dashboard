<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DashboardOrder extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'mobile',
        'start_date',
        'end_date',
        'amount_paid',
        'order_status',
        'pickup_location',
        'number_of_bikes',
        'is_woo'
      ];

      public function bikesDashboardOrder(): HasMany
    {
        return $this->hasMany(BikesDashboardOrder::class);
    }
}
