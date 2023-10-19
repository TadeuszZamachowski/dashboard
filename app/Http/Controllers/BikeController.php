<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\Code;
use App\Models\DashboardOrder;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\Bike;

class BikeController extends Controller
{
    //show all bikes
    public function index() {
        $bikes = Bike::with('dashboardOrder')->get();
        return view('bikes.index', [
            'bikes' => $bikes
        ]);
    }

    //show single bike
    public function show(Bike $bike) {
        return view('bikes.show', [
            'bike' => $bike
        ]);
    }

    //show create form
    public function create() {
        return view('bikes.create', [
            'accessories' => Accessory::all(),
            'codes' => Code::all(),
            'locations' => Location::all()
        ]);
    }

    //store bike data
    public function store(Request $request) {
        $validation = $request->validate([
            'color' => 'required',
            'type' => 'required',
            'gear' => 'required',
            'accessory' => 'required',
            'code' =>'required',
            'location' => 'required',
            'rack' => 'required',
            'status' => 'required',
            'dashboard_order_id' => ''
        ]);
        
        Bike::create($validation);

        return redirect('/bikes')->with('success', 'Bike succesfully added.');
    }

    //show edit form'
    public function edit(Bike $bike) {
        return view('bikes.edit', ['bike' => $bike]);
    }

    //update bike
    public function update(Request $request, Bike $bike) {
        $formFields = $request->validate([
            'color' => 'required',
            'type' => 'required',
            'gear' => 'required',
            'accessory' => 'required',
            'code' =>'required',
            'location' => 'required',
            'rack' => 'required',
            'status' => 'required',
            'dashboard_order_id' => ''
        ]);
        
        $bike->update($formFields);

        return redirect('/bikes/'.$bike->id)->with('success', 'Bike succesfully updated.');
    }

    //delete bike
    public function destroy(Bike $bike) {
        $bike->delete();
        return redirect('/bikes')->with('success', 'Bike deleted succesfully');
    }
}
