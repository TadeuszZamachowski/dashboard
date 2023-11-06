<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardIncident extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'date',
        'dashboard_order_id',
        'bike_id',
        'report',
        'action'
    ];
}
