<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\BikesDashboardOrder;
use App\Models\DashboardOrder;
use Illuminate\Http\Request;

class BikesDashboardOrderController extends Controller
{
    public function show() {
        return view('assign');
    }
    public function store(Request $request) {
        $this->validate($request, [
            'order_id' => 'required',
            'bike_id' => 'required'
        ]);

        $data['order_id'] = $request['order_id'];
        $data['bike_id'] = $request['bike_id'];
        $data['start_date'] = DashboardOrder::where('id', '=', $request['order_id'])->first(['start_date'])->start_date;
        $data['end_date'] = DashboardOrder::where('id', '=', $request['order_id'])->first(['end_date'])->end_date;

        $bike = Bike::find($request['bike_id']);
        if ($bike) {
            if($bike->dashboard_order_id == null) {
                $bike->dashboard_order_id = $request['order_id'];
                $bike->save();

                BikesDashboardOrder::create($data);
                return redirect('/')->with('success', 'Bike succesfully assigned.');
            }
            return redirect('/')->with('error', 'Bike already assigned to order!');
        }

        return redirect('/')->with('error', 'Bike with the specified id doesnt exist!');
    }

    public function index() {
        return view('history.index', [
            'history' => BikesDashboardOrder::orderByDesc('id')->get()
        ]);
    }
}
