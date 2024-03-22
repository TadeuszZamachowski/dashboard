<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\BikesCheck;
use Illuminate\Http\Request;

class BikesCheckController extends Controller
{
    public function create(Bike $bike) {
        return view('bikes.maintenance',[
            'bike_id' => $bike->id
        ]);
    }

    public function store (Request $request) {
        $validation = $request->validate([
            'bike_id' => 'required',
            'work' => 'required',
            'rust' => 'required',
            'brakes' => 'required',
            'wheels' => 'required',
            'chain' =>'required',
            'notes' => ''
        ]);
        
        BikesCheck::create($validation);

        return redirect('/bikes')->with('success', 'Maintenance succesfully recorded.');
    }
    
}
