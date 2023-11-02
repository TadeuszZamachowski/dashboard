<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DashboardOrder extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'dashboard_order_id';

    protected $fillable = [
        'dashboard_order_id',
        'first_name',
        'last_name',
        'email',
        'mobile',
        'start_date',
        'end_date',
        'amount_paid',
        'payment_method',
        'order_status',
        'pickup_location',
        'address',
        'number_of_bikes',
        'is_woo',
        'event_id',
        'bikes_assigned'
      ];

      public function bikes(): HasMany
    {
        return $this->hasMany('App\Models\Bike', 'dashboard_order_id', 'dashboard_order_id');
    }
}
