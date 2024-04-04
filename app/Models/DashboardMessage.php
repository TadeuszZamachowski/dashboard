<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardMessage extends Model
{
    
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'value'
      ];

}
