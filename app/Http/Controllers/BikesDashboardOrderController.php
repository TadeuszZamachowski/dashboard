<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\BikesDashboardOrder;
use App\Models\DashboardOrder;
use App\Services\TwilioService;
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
                'bikes' => Bike::where('status', '=', 'in')->orderBy('rack')->get()
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

        $assignedBikes = array();
        for($i = 0; $i < count($request->bike_ids); $i++) {
            $data['bike_id'] = $request->bike_ids[$i];

            $bike = Bike::find($request->bike_ids[$i]);
            if ($bike) {
                $assignedBikes[] = $bike;
                if($bike->dashboard_order_id == null) {
                    $bike->status = 'out';
                    $bike->dashboard_order_id = $order->dashboard_order_id;
                    $bike->save();
    
                    BikesDashboardOrder::create($data);
                } 
            }
        }
        
        $order->update(array(
            'order_status' => 'Assigned',
            'bikes_assigned' => 1
        ));

        $response = "";
        if($order->pickup_location == "Mercato") {
            $sms = new SmsController(new TwilioService());
            $result = $sms->sendSMS($order->mobile, $this::getMessage($assignedBikes));
            if($result == 1) {
                $response = "Sms sent!";
            } else {
                $response = "Couldn't send sms, Invalid phone number";
            }
    }
        return redirect()->to($request->last_url)->with('success', 'Bike succesfully assigned. '.$response);
         
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

    public static function getMessage($assignedBikes) {
        $message = 'Here are your rack numbers and codes: '. "\r\n";
        foreach($assignedBikes as $bike) {
            $message .= '=> Rack: '. $bike->rack .' | Code: '.$bike->code . "\r\n";
        }
        $message .= 'Please take a photo of the bike when picking it up and send it to +61 418 883 631. Upon return, hang the bike on the same bike rack. Attach the bike with the same lock code and send us a photo again.';
        return $message;   
    }
 }
