<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\BikeColor;
use App\Models\BikeRack;
use App\Models\Code;
use App\Models\DashboardOrder;
use App\Models\Location;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Bike;
use Illuminate\Support\Facades\DB;

class BikeController extends Controller
{
    const LOCATIONS = ['Mercato', 'Airbnb', 'Suffolk'];

    public function filterBikes($filter) {
        if($filter != 'None') {
            $bikes = Bike::with('dashboardOrder')->where('location', $filter)->orderBy('rack')->get();
        } else {
            $bikes = Bike::with('dashboardOrder')->orderBy('rack')->get();
        }
        return $bikes;
    }

    //show all bikes
    public function index(Request $request) {
        if($request->filter == null) {
            $request->filter = 'Mercato';
        }
        $bikes = $this->filterBikes($request->filter);
        return view('bikes.index', [
            'bikes' => $bikes,
            'categories' => $this::LOCATIONS,
            'filter' => $request->filter
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
            'codes' => Code::orderBy('value')->get(),
            'locations' => Location::all(),
            'colors' => BikeColor::all(),
            'racks' => BikeRack::all()
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
            'state' => '',
            'status' => 'required',
            'helmet' => 'required',
            'notes' => '',
            'dashboard_order_id' => ''
        ]);
        
        Bike::create($validation);

        return redirect('/bikes')->with('success', 'Bike succesfully added.');
    }

    //show edit form'
    public function edit(Bike $bike) {
        return view('bikes.edit', [
            'bike' => $bike,
            'accessories' => Accessory::all(),
            'codes' => Code::orderBy('value')->get(),
            'locations' => Location::all(),
            'colors' => BikeColor::all(),
            'racks' => BikeRack::all()
        ]);
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
            'state' => '',
            'status' => 'required',
            'helmet' => 'required',
            'notes' => '',
            'dashboard_order_id' => ''
        ]);
        
        $bike->update($formFields);

        return redirect('/bikes')->with('success', 'Bike ' . $bike->id . ' succesfully updated.');
    }

    //delete bike
    public function destroy(Bike $bike) {
        $bike->delete();
        return redirect('/bikes')->with('success', 'Bike deleted succesfully');
    }
}
