<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\BikesCheck;
use Illuminate\Http\Request;

class BikesCheckController extends Controller
{
    public function store(Bike $bike) {
        $data['bike_id'] = $bike->id;
        BikesCheck::create($data);

        return redirect()->back()->with('success', 'Bike check saved');
    }
}
