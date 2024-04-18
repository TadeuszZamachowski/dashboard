<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//settings for automation and sms 
// automation => ID 1
// sms => ID 2
class DashboardAutomation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'enabled'
    ];
}
