<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\BikesDashboardOrder;
use App\Models\DashboardOrder;
use Illuminate\Http\Request;

class BikesDashboardOrderController extends Controller
{

    public function index() {
        $history = BikesDashboardOrder::with('bike')->with('dashboardOrder')->orderByDesc('id')->get();
        return view('history.index', [
            'history' => $history
        ]);
    }

    public function show(Request $request, DashboardOrder $order) {
        if($request->reassign == true) {
            $order->update(array(
                'bikes_assigned' => null
            ));
            $prevAssignedBikes = Bike::where('dashboard_order_id', $order->dashboard_order_id)->get();
            foreach($prevAssignedBikes as $bike) {
                $bike->update(array(
                    'status' => 'in',
                    'dashboard_order_id' => null
                ));
            }
            $history = BikesDashboardOrder::where('order_id', $order->dashboard_order_id)->get();
            foreach($history as $entry) {
                $entry->delete();
            }
        }

        if($order->bikes_assigned == 1) {
            return view('assign.check', [
                'order' => $order,
                'bikes' => Bike::where('dashboard_order_id', $order->dashboard_order_id)->get()
            ]);
        } else {
            return view('assign.assign', [
                'order' => $order,
                'bikes' => Bike::where('status', '=', 'in')->where('location', 'LIKE', $order->pickup_location)->orderBy('rack')->get()
            ]);
        }
    }

    public function showBikeSide(Request $request, Bike $bike) {
        return view('assign.assign-bike', [
            'bike' => $bike,
            'orders' => DashboardOrder::where('order_status', '!=', 'Completed')->where('order_status', '!=', 'Cancelled')
                        ->where('order_status', '!=', 'Failed')
                        ->where('order_status', '!=', 'Archived')
                        ->orderByDesc('dashboard_order_id')->get()
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
            $status = 'Assigned';
            $order->update(array(
                'order_status' => $status,
                'bikes_assigned' => 1
            ));
            return redirect()->to($request->last_url)->with('success', 'Bike succesfully assigned.');
        } elseif($result == 2) {
            return redirect('/')->with('error', 'Bike already assigned to order!');
        } else {
            return redirect('/')->with('error', 'Bike with the specified id doesnt exist!');
        }
    }

    public function storeBikeSide(Request $request, Bike $bike) {
        $this->validate($request, [
            'dashboard_order_id' => 'required'
        ]);

        $order = DashboardOrder::where('dashboard_order_id', $request->dashboard_order_id)->first();

        $data['bike_id'] = $bike->id;
        $data['order_id'] = $order->dashboard_order_id;
        $data['start_date'] = $order->start_date;
        $data['end_date'] = $order->end_date;

        BikesDashboardOrder::create($data);
        $bike->update(array(
            'status' => 'out',
            'dashboard_order_id' => $order->dashboard_order_id
        ));

        $order->update(array(
            'order_status' => 'Processing',
            'bikes_assigned' => 1
        ));

        return redirect()->to($request->last_url)->with('success', 'Bike succesfully assigned.');
    }

    public function destroy(Request $request, Bike $bike) {
        $order_id = $bike->dashboard_order_id;
        $bike->update(array(
            'status'=> 'in',
            'dashboard_order_id'=> null
        ));

        $history = BikesDashboardOrder::where('order_id', $order_id)->where('bike_id', $bike->id)->first();
        $history->delete();

        return redirect()->to($request->last_url)->with('success', 'Bike succesfully freed.');
    }
 }
