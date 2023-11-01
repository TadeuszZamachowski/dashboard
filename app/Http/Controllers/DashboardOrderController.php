<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\BikesDashboardOrder;
use App\Models\DashboardOrder;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;

class DashboardOrderController extends Controller
{
    public static $COLOR = 0;
    const PAGINATION_NUMBER = 20;
    const CATEGORIES = [
        'Pending',
        'On-hold',
        'Processing',
        'Completed',
        'Cancelled',
        'Failed'
    ];

    public function filterOrders($filter) {
        if($filter != null) {
            $orders = DashboardOrder::where('order_status', '!=', 'Completed')->where('order_status',$filter)->orWhere('order_status','wc-'.strtolower($filter))
        ->orderByDesc('dashboard_order_id')->paginate($this::PAGINATION_NUMBER);
        } else {
            $orders = DashboardOrder::where('order_status', '!=', 'Completed')->
            orderByDesc('dashboard_order_id')->paginate($this::PAGINATION_NUMBER);
        }
        return $orders;
    }

    public function searchOrders($search) {
        return DashboardOrder::where('order_status','!=','Completed')
        ->where('first_name','LIKE', '%'.$search.'%')
        ->orWhere('last_name', 'LIKE', '%'.$search.'%')
        ->orWhere('email', 'LIKE', '%'.$search.'%')
        ->orWhere('mobile', 'LIKE', '%'.$search.'%')
        ->orWhere('amount_paid', 'LIKE', '%'.$search.'%')
        ->orWhere('pickup_location', 'LIKE', '%'.$search.'%')
        ->orderByDesc('dashboard_order_id')->paginate($this::PAGINATION_NUMBER);
    }
    public function index(Request $request) {
        $orders = $this->filterOrders($request->filter);
        if($request->search != null) {
            $orders = $this->searchOrders($request->search);
        }

        return view('orders.index', [
            'orders' => $orders,
            'categories' =>  $this::CATEGORIES,
            'filter' => $request->filter,
            'search' => $request->search
        ]);
    }

    public function show(DashboardOrder $order) {
        return view('orders.show', [
            'order' => $order,
            'archive' => false
        ]);
    }

    public function showArchive(DashboardOrder $order) {
        $history = BikesDashboardOrder::where('order_id', $order->dashboard_order_id)->get();
        $bikes = array();
        foreach($history as $item) {    
            $bikes[] = Bike::where('id', $item->bike_id)->first();
        }
        
        return view('orders.show', [
            'order' => $order,
            'archive' => true,
            'bikes' => $bikes
        ]);
    }

    public function create() {
        return view('orders.create');
    }

    public function createEvent($name, $description, $startDate, $endDate) {//google calendar
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
            'payment_method' => 'required',
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
        $data['payment_method'] = $request['payment_method'];
        $data['order_status'] = 'Pending';
        $data['pickup_location'] = $request['pickup_location'];
        $data['number_of_bikes'] = $request['number_of_bikes'];
        $event = $this->createEvent($data['first_name'],$data['dashboard_order_id'], Carbon::parse($data['start_date']), Carbon::parse($data['end_date']));
        $data['event_id'] = $event->id;
        
        DashboardOrder::create($data);

        return redirect('/')->with('success', 'Order succesfully added.');
    }

    public function edit(DashboardOrder $order) {
        $categories = $this::CATEGORIES;
        return view('orders.edit', compact('order','categories')
        );
    }

    public function updateWooOrder($order) {
        Post::where('ID', '=', $order->dashboard_order_id)->update(array('post_status' => 'wc-'.strtolower($order->order_status)));
        
    }

    public function freeBikes($order) {
        $orderWithBikes = DashboardOrder::where('dashboard_order_id','=',$order->dashboard_order_id)->with('bikes')->first();
            foreach($orderWithBikes->bikes as $bike) {
                $bike->update(array(
                    'status' => 'in',
                    'dashboard_order_id' => null
                ));
            }
    }

    public function deleteEvent($order) {
        //delete event from google calendar
        if($order->event_id != null) {
            $event = Event::find($order->event_id);
            if($event->status != 'cancelled') {
                $event->delete();
            }
        }
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
            'payment_method' => 'required',
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
        $data['payment_method'] = $request['payment_method'];
        $data['order_status'] = $request['order_status'];
        $data['pickup_location'] = $request['pickup_location'];
        $data['number_of_bikes'] = $request['number_of_bikes'];

        
        
        $order->update($data);
        if($order->is_woo == 1) {
            $this->updateWooOrder($order);
        }
        if($order->order_status == 'Completed') {
            $this->freeBikes($order);
            $this->deleteEvent($order);
            return redirect()->to($request->last_url)->with('success', 'Order '. $order->dashboard_order_id .' completed and moved to archive');
        }

        return redirect()->to($request->last_url)->with('success', 'Order '. $order->dashboard_order_id .' edited.');
    }

    public function updateStatusOnly(Request $request, DashboardOrder $order) {
        $this->validate($request, [
            'order_status' => 'required'
        ]);
        
        $order->update(array(
            'order_status' => $request['order_status']
        ));

        if($order->is_woo == 1) {
            $this->updateWooOrder($order);
        }

        if($order->order_status == 'Completed') {
            $this->freeBikes($order);
            $this->deleteEvent($order);
            return redirect()->back()->with('success', 'Order '. $order->dashboard_order_id .' completed and moved to archive');
        } 

        return redirect()->back()->with('success', 'Status of '. $order->dashboard_order_id .' edited.');
    }




    public function destroy(DashboardOrder $order) {
        $this->deleteEvent($order);

        $order->delete();
        return back()->with('success', 'Order deleted succesfully');
    }

    public function showSchedule() {
        return view('schedule', [
            'nullOrders' => DashboardOrder::where('event_id', null)->where('order_status', '!=', 'Completed')->get()
        ]);
    }





    public function updateSchedule() { //creates google events for woo commerce orders
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





    public function archive() {
        return view('orders.archive', [
            'orders' => DashboardOrder::where('order_status', 'Completed')->orderByDesc('dashboard_order_id')
            ->paginate($this::PAGINATION_NUMBER)
        ]);
    }
}
