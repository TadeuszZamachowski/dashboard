<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\BikesDashboardOrder;
use App\Models\DashboardOrder;
use Illuminate\Http\Request;

class BikesDashboardOrderController extends Controller
{
    public function show(DashboardOrder $order) {
        $bikes = Bike::where('status', '=', 'in')->orderBy('rack')->get();
        return view('assign', [
            'order' => $order,
            'bikes' => $bikes
        ]);
    }
    public function store(Request $request, DashboardOrder $order) {
        $this->validate($request, [
            'bike_ids' => 'required'
        ]);
        $data['order_id'] = $order->dashboard_order_id;
        $data['start_date'] = $order->start_date;
        $data['end_date'] = $order->end_date;

        $result = 0;

        for($i = 0; $i < count($request->bike_ids); $i++) {
            $data['bike_id'] = $request->bike_ids[$i];

            $bike = Bike::find($request->bike_ids[$i]);
            if ($bike) {
                if($bike->dashboard_order_id == null) {
                    $bike->status = 'out';
                    $bike->dashboard_order_id = $order->dashboard_order_id;
                    $bike->save();
    
                    BikesDashboardOrder::create($data);
                    $result = 1;
                } else {
                    $result = 2;
                }
            }
        }

        if($result == 1) {
            return redirect('/')->with('success', 'Bike succesfully assigned.');
        } elseif($result == 2) {
            return redirect('/')->with('error', 'Bike already assigned to order!');
        } else {
            return redirect('/')->with('error', 'Bike with the specified id doesnt exist!');
        }
    }

    public function index() {
        $history = BikesDashboardOrder::with('bike')->with('dashboardOrder')->orderByDesc('id')->get();
        return view('history.index', [
            'history' => $history
        ]);
    }
}
