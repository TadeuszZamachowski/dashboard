<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardAutomation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'enabled'
    ];
}
