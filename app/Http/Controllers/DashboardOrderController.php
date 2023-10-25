<?php

namespace App\Http\Controllers;

use App\Models\DashboardOrder;
use App\Models\Post;
use Illuminate\Http\Request;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;

class DashboardOrderController extends Controller
{
    public static $COLOR = 0;
    public function index() {
        $categories = [
            'Pending',
            'On-Hold',
            'Processing',
            'Completed'
        ];

        return view('orders.index', [
            'orders' => DashboardOrder::orderByDesc('dashboard_order_id')->get(),
            'categories' =>  $categories
        ]);
    }

    public function show(DashboardOrder $order) {
        return view('orders.show', [
            'order' => $order
        ]);
    }

    public function create() {
        return view('orders.create');
    }

    public function createEvent($name, $description, $startDate, $endDate) {
        $event = new Event;

        if (str_contains($startDate, '-0001') || str_contains($endDate, '-0001')) {
            return -1;
        }

        $event->name = $name;
        $event->description = $description;
        $event->startDateTime = $startDate;
        $event->endDateTime = $endDate;

        $newEvent = $event->save();
        return $newEvent;
    }

    public function store(Request $request) {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'start_date' =>'required',
            'end_date' => 'required',
            'amount_paid' => 'required',
            'pickup_location' => 'required',
            'number_of_bikes' => 'required'
        ]);

        $data['dashboard_order_id'] = DashboardOrder::max('dashboard_order_id') + 1;
        $data['first_name'] = $request['first_name'];
        $data['last_name'] = $request['last_name'];
        $data['email'] = $request['email'];
        $data['mobile'] = $request['mobile'];
        $data['start_date'] = $request['start_date'];
        $data['end_date'] = $request['end_date'];
        $data['amount_paid'] = $request['amount_paid'];
        $data['order_status'] = 'Pending';
        $data['pickup_location'] = $request['pickup_location'];
        $data['number_of_bikes'] = $request['number_of_bikes'];
        $event = $this->createEvent($data['first_name'],$data['dashboard_order_id'], Carbon::parse($data['start_date']), Carbon::parse($data['end_date']));
        $data['event_id'] = $event->id;
        
        DashboardOrder::create($data);

        return redirect('/')->with('success', 'Order succesfully added.');
    }

    public function edit(DashboardOrder $order) {
        $categories = [
            'Pending',
            'On-Hold',
            'Processing',
            'Completed'
        ];
        return view('orders.edit', compact('order','categories')
        );
    }

    public function update(Request $request, DashboardOrder $order) {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'start_date' =>'required',
            'end_date' => 'required',
            'amount_paid' => 'required',
            'order_status' => 'required',
            'pickup_location' => 'required',
            'number_of_bikes' => 'required'
        ]);

        $data['first_name'] = $request['first_name'];
        $data['last_name'] = $request['last_name'];
        $data['email'] = $request['email'];
        $data['mobile'] = $request['mobile'];
        $data['start_date'] = $request['start_date'];
        $data['end_date'] = $request['end_date'];
        $data['amount_paid'] = $request['amount_paid'];
        $data['order_status'] = $request['order_status'];
        $data['pickup_location'] = $request['pickup_location'];
        $data['number_of_bikes'] = $request['number_of_bikes'];

        
        
        $order->update($data);
        if($order->order_status == 'Completed') {
            //update corresponding woo commerce order
            if ($order->is_woo != 0) {
                Post::where('ID', '=', $order->dashboard_order_id)->update(array('post_status' => 'wc-completed'));
            }
            //free up the bikes assigned to the order
            $orderWithBikes = DashboardOrder::where('dashboard_order_id','=',$order->dashboard_order_id)->with('bikes')->first();
            foreach($orderWithBikes->bikes as $bike) {
                $bike->update(array(
                    'status' => 'in',
                    'dashboard_order_id' => null
                ));
            }
        }

        return redirect('/')->with('success', 'Order '. $order->dashboard_order_id .' edited.');
    }

    public function updateStatusOnly(Request $request, DashboardOrder $order) {
        $this->validate($request, [
            'order_status' => 'required'
        ]);
        
        $order->update(array(
            'order_status' => $request['order_status']
        ));

        if($order->order_status == 'Completed') {
            //update corresponding woo commerce order
            if ($order->is_woo != 0) {
                Post::where('ID', '=', $order->dashboard_order_id)->update(array('post_status' => 'wc-completed'));
            }
            //free up the bikes assigned to the order
            $orderWithBikes = DashboardOrder::where('dashboard_order_id','=',$order->dashboard_order_id)->with('bikes')->first();
            foreach($orderWithBikes->bikes as $bike) {
                $bike->update(array(
                    'status' => 'in',
                    'dashboard_order_id' => null
                ));
            }
        }

        return redirect('/')->with('success', 'Status of '. $order->dashboard_order_id .' edited.');
    }

    public function destroy(DashboardOrder $order) {
        if($order->event_id != null) {
            $event = Event::find($order->event_id);
            if($event->status != 'cancelled') {
                $event->delete();
            }
        }

        $order->delete();
        return redirect('/')->with('success', 'Order deleted succesfully');
    }

    public function showSchedule() {
        return view('schedule', [
            'nullOrders' => DashboardOrder::where('event_id', null)->get()
        ]);
    }

    public function updateSchedule() { //creates google events for woo commerce orders
        // $events = Event::get();

        // foreach($events as $event) {
        //     $event->delete();
        // }
        $orders = DashboardOrder::where('event_id', null)->get();
        if(count($orders) <= 0) {
            return redirect('/schedule')->with('success', 'No records were updated');
        }
        
        foreach($orders as $order) {
            $event = $this->createEvent($order->first_name,$order->dashboard_order_id, Carbon::parse($order->start_date), Carbon::parse($order->end_date));
            if($event instanceof Event) {
                $order->update(array(
                    'event_id' => $event->id
                ));
            } else {
                error_log("Incorrect date when setting an event for an order!");
                $order->update(array(
                    'event_id' => -1
                ));
                continue;
            }
        }
        return redirect('/schedule')->with('success', 'Calendar updated!');
    }
}
