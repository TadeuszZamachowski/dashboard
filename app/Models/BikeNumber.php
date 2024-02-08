<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikeNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'count'
    ];
}
