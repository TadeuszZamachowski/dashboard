<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//dictionary for bikes

class Location extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'value'
    ];
}
