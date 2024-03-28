<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\BikeColor;
use App\Models\BikeRack;
use App\Models\BikesCheck;
use App\Models\BikeNumber;
use App\Models\BikesDashboardOrder;
use App\Models\Code;
use App\Models\DashboardOrder;
use App\Models\Location;
use App\Services\ClicksendService;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Bike;
use Illuminate\Support\Facades\DB;

class BikeController extends Controller
{
    const LOCATIONS = ['Mercato', 'Airbnb', 'Suffolk'];
    const TYPES = ['Cruiser', 'Urban', 'Kid'];

    public function filterBikes($filter) {
        if($filter != 'None') {
            $bikes = Bike::with('dashboardOrder')->with('bikeChecks')->where('status', 'NOT LIKE', 'sold')
                            ->where('location', $filter)->orderBy('id')->get();
        } else {
            $bikes = Bike::with('dashboardOrder')->with('bikeChecks')->where('status', 'NOT LIKE', 'sold')->orderBy('id')->get();
        }
        return $bikes;
    }

    public function filterStats($filter) {
        $stats = array();
        if($filter != 'None') {
            $in = Bike::where('status',"LIKE", 'in')->where('location',$filter)->count();
            $out = Bike::where('status','LIKE','out')->where('location',$filter)->count();
            $total = Bike::where('status', 'NOT LIKE', 'sold')->where('location',$filter)->count();

        } else {
            $in = Bike::where('status',"LIKE", 'in')->count();
            $out = Bike::where('status','LIKE','out')->count();
            $total = Bike::where('status', 'NOT LIKE', 'sold')->count();
        }
        $stats = [$in, $out, $total];
        return $stats;
    }

    //show all bikes
    public function index(Request $request) {
        if($request->filter == null) {
            $request->filter = 'None';
        }

        $bikes = $this->filterBikes($request->filter);
        $stats = $this->filterStats($request->filter);
        $racks = BikeRack::with('bike')->get()->sortBy('value');
        
        // if($request->filter == 'Mercato') {
        //     return view('bikes.mercato-index', [
        //         'racks' => $racks,
        //         'categories' => Location::all(),
        //         'filter' => $request->filter,
        //     ]);
        // } else {
        //     return view('bikes.index', [
        //         'bikes' => $bikes,
        //         'categories' => Location::all(),
        //         'filter' => $request->filter,
        //     ]);
        // }

        return view('bikes.index', [
            'bikes' => $bikes,
            'categories' => Location::all(),
            'filter' => $request->filter,

            'in' => $stats[0],
            'out' => $stats[1],
            'total' => $stats[2]
        ]);
    }

    //show single bike
    public function show(Bike $bike) {
        $history = BikesDashboardOrder::where('bike_id', $bike->id)->get();
        $checks = BikesCheck::where('bike_id', $bike->id)->get();
        return view('bikes.show', [
            'bike' => $bike,
            'history' => $history,
            'checks' => $checks
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
            'rack' => '',
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
            'rack' => '',
            'state' => '',
            'status' => 'required',
            'helmet' => 'required',
            'notes' => '',
            'dashboard_order_id' => '',
            'number' => 'required'
        ]);
        
        $bike->update($formFields);

        return redirect('/bikes')->with('success', 'Bike ' . $bike->id . ' succesfully updated.');
    }

    //delete bike
    public function destroy(Bike $bike) {
        $bike->delete();
        return redirect('/bikes')->with('success', 'Bike deleted succesfully');
    }

    public function boundToRack(BikeRack $rack) {
        return view('bikes.bikeToRack', [
            'rack' => $rack,
            'bikes' => Bike::where('location', 'LIKE', 'Mercato')->where('rack', '0')->get()
        ]);
    }

    public function boundToRackStore(Request $request, BikeRack $rack) {
        $rack->bike_id = $request->bike_id;

        $bike = Bike::where('id', $request->bike_id)->first();
        $bike->rack = $rack->value;
        $bike->save();
        $rack->save();

        return redirect('/bikes')->with('success', 'Bike bounded to rack.');
    }

    public function freeRack(BikeRack $rack) {
        $bike = Bike::where('id', $rack->bike_id)->first();
        $bike->rack = 0;
        $bike->save();

        $rack->bike_id = null;
        $rack->save();

        return redirect('/bikes')->with('success', 'Rack freed');
    }

    public function mapBikes() {
        $bikes = Bike::where('location', 'LIKE', 'Mercato')->get();
        $racks = BikeRack::all();
        foreach($bikes as $bike) {
            foreach($racks as $rack) {
                if($bike->rack == $rack->value) {
                    $rack->bike_id = $bike->id;
                    $rack->save();
                }
            }
        }
        return redirect('/bikes')->with('success','Bikes mapped');
    }

    public static function recordNumberOfBikes() {
        $count = Bike::where('status', 'LIKE', 'out')->where('dashboard_order_id', '!=', 'NULL')->count();
        $data = array('count' => $count);
        BikeNumber::create($data);
        return "Success";
    }

    public function bikeArchive() {
        return view('bikes.archive', [
            'bikes' => Bike::with('dashboardOrder')->where('status', 'LIKE', 'sold')->orderBy('id')->get()
        ]);
    }

    public function inventory(Request $request) {
        if($request->filter == null) {
            $request->filter = 'None';
        }

        $bikes = $this->filterBikes($request->filter);
        $stats = $this->filterStats($request->filter);
        $racks = BikeRack::with('bike')->get()->sortBy('value');
        
        // if($request->filter == 'Mercato') {
        //     return view('bikes.mercato-index', [
        //         'racks' => $racks,
        //         'categories' => Location::all(),
        //         'filter' => $request->filter,
        //     ]);
        // } else {
        //     return view('bikes.index', [
        //         'bikes' => $bikes,
        //         'categories' => Location::all(),
        //         'filter' => $request->filter,
        //     ]);
        // }

        return view('bikes.inventory', [
            'bikes' => $bikes,
            'categories' => Location::all(),
            'filter' => $request->filter,

            'in' => $stats[0],
            'out' => $stats[1],
            'total' => $stats[2]
        ]);
    }
}
