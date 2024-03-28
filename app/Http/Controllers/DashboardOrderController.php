<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Bike;
use App\Models\BikeColor;
use App\Models\BikesDashboardOrder;
use App\Models\DashboardOrder;
use App\Models\DashboardOrderAccessory;
use App\Services\ClicksendService;
use App\Models\Location;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;
use DateTime;

class DashboardOrderController extends Controller
{
    const ENABLE_SMS = true;
    const ENABLE_CALLENDAR = false;
    //const PAGINATION_NUMBER = 20;
    const CATEGORIES = [
        'Pending',
        'Processing',
        'Assigned',
        'Completed',
        'Archived'
    ];


    public function filterOrders($filter) {
        if($filter != null) {
            $orders = DashboardOrder::where('order_status', '!=', 'Archived')->where('order_status',$filter)->orWhere('order_status','wc-'.strtolower($filter))
        ->orderBy('start_date')->with('history')->get();
        } else {
            $orders = DashboardOrder::where('order_status', '!=', 'Archived')->
            orderBy('start_date')->with('history')->get();
        }
        return $orders;
    }

    public function searchOrders($search, $isArchive) {

        if($isArchive) {
            return DashboardOrder::where('dashboard_order_id','LIKE', '%'.$search.'%')
        ->orWhere('first_name','LIKE', '%'.$search.'%')
        ->orWhere('last_name', 'LIKE', '%'.$search.'%')
        ->where('order_status', 'LIKE', 'Archived')
        ->orderBy('start_date')->with('history')->paginate(50);
        } else {
            return DashboardOrder::where([
                ['order_status', '!=', 'Archived'],
                ['dashboard_order_id', 'LIKE', '%'.$search.'%']
            ])->orWhere([
                ['first_name','LIKE', '%'.$search.'%'],
                ['last_name', 'LIKE', '%'.$search.'%']
            ])->orderBy('start_date')->with('history')->get();
        }
    }
    public function index(Request $request) {
        $orders = $this->filterOrders($request->filter);
        if($request->search != null) {
            $orders = $this->searchOrders($request->search, false);
        }

        return view('orders.index', [
            'orders' => $orders,
            'processing' => DashboardOrder::where('order_status', 'LIKE', 'Processing')->orWhere('order_status', 'LIKE', 'Assigned')->count(),
            'assigned' => Bike::where('status', 'LIKE', 'out')->where('dashboard_order_id','!=',"NULL")->count(),
            'categories' =>  $this::CATEGORIES,
            'filter' => $request->filter,
            'search' => $request->search
        ]);
    }

    public function show(DashboardOrder $order) {
        return view('orders.show', [
            'order' => $order,
            'archive' => $order->order_status == 'Archived'
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
            'archive' => $order->order_status == 'Archived',
            'bikes' => $bikes
        ]);
    }

    public function create() {
        return view('orders.create', [
            'locations' => Location::all(),
            'accommodations' => Accommodation::all(),
        ]);
    }

    public function createEvent($name, $description, $startDate, $endDate) {//google calendar
        $event = new Event;

        if (str_contains($startDate, '-0001') || str_contains($endDate, '-0001')) {
            return -1;
        }

        $event->name = "(Return ". date('d F',strtotime($endDate)) .")  ".   $name;
        $event->description =$description;
        $event->startDateTime = $startDate;
        $event->endDateTime = $endDate;

        $newEvent = $event->save();
        return $newEvent;
    }

    public function store(Request $request) {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => '',
            'email' => '',
            'mobile' => '',
            'accommodation' => '',
            'start_date' =>'',
            'end_date' => '',
            'amount_paid' => '',
            'payment_method' => '',
            'pickup_location' => '',
            'address' => '',
            'number_of_bikes' => ''
        ]);

        $requestData = $request->all();
        //dd($requestData);
       

        foreach ($requestData as $key => $value) {
            if ($value == null && ($key == 'start_date' || $key == 'end_date')) {
                $requestData[$key] = new DateTime();
            } else if($value == null && ($key == 'amount_paid')) {
                $requestData[$key] = 0;
            } else if($value == null) {
                $requestData[$key] = "";
            }
        }

        $data['dashboard_order_id'] = floor(time()-999999999);
        $data['first_name'] = $requestData['first_name'];
        $data['last_name'] = $requestData['last_name'];
        $data['email'] = $requestData['email'];
        $data['mobile'] = $requestData['mobile'];
        $data['accommodation'] = $requestData['accommodation'];
        $data['start_date'] = $requestData['start_date'];
        $data['end_date'] = $requestData['end_date'];
        $data['amount_paid'] = $requestData['amount_paid'];
        $data['payment_method'] = $requestData['payment_method'];
        $data['order_status'] = 'Pending';
        $data['pickup_location'] = $requestData['pickup_location'];
        $data['address'] = $requestData['address'];
        $data['number_of_bikes'] = $requestData['number_of_bikes'];
        if($this::ENABLE_CALLENDAR) {
            $event = $this->createEvent($data['first_name'],$data['dashboard_order_id'], Carbon::parse($data['start_date']), Carbon::parse($data['end_date']));
            $data['event_id'] = $event->id;
        }
        
        DashboardOrder::create($data);

        return redirect('/')->with('success', 'Order succesfully added.');
    }

    public function edit(DashboardOrder $order) {
        $categories = $this::CATEGORIES;
        return view('orders.edit', [
            'order' => $order,
            'categories' => $categories,
            'locations' => Location::all(),
            'accommodations' => Accommodation::all()
        ]
        );
    }

    public function updateWooOrder($order) {
        if($order->order_status == 'Archived') {
            Post::where('ID', '=', $order->dashboard_order_id)->update(array('post_status' => 'wc-completed'));
        } else if ($order->order_status == 'Assigned'){
            Post::where('ID', '=', $order->dashboard_order_id)->update(array('post_status' => 'wc-processing'));
        } else {
            Post::where('ID', '=', $order->dashboard_order_id)->update(array('post_status' => 'wc-'.strtolower($order->order_status)));
        }
        
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
            'last_name' => '',
            'email' => '',
            'mobile' => '',
            'accommodation' => '',
            'start_date' =>'',
            'end_date' => '',
            'amount_paid' => '',
            'payment_method' => '',
            'order_status' => '',
            'pickup_location' => '',
            'address' => '',
            'number_of_bikes' => 'required'
        ]);

        $data['first_name'] = $request['first_name'];
        $data['last_name'] = $request['last_name'];
        $data['email'] = $request['email'];
        $data['mobile'] = $request['mobile'];
        $data['accommodation'] = $request['accommodation'];
        $data['start_date'] = $request['start_date'];
        $data['end_date'] = $request['end_date'];
        $data['amount_paid'] = $request['amount_paid'];
        $data['payment_method'] = $request['payment_method'];
        $data['order_status'] = $request['order_status'];
        $data['pickup_location'] = $request['pickup_location'];
        $data['address'] = $request['address'];
        $data['number_of_bikes'] = $request['number_of_bikes'];

        $order->update($data);
        if($order->is_woo == 1) {
            $this->updateWooOrder($order);
        }
        $response = "";
        if($order->order_status == 'Completed') {
            $this->freeBikes($order);
            $this->deleteEvent($order);
        } else if($order->order_status == 'Archived') {
            if($this::ENABLE_SMS) {
                $sms = new SmsController(new ClicksendService());
                $result = $sms->sendSMS($order->mobile, SmsController::getReturnMessage());

                if($result == 1) {
                    $response = "Sms sent!";
                } else {
                    $response = "Couldn't send sms, Invalid phone number";
                }
            }
        } else if ($order->order_status == 'Cancelled') {
            $this->freeBikes($order);
            $this->deleteEvent($order);

            $history = BikesDashboardOrder::where('order_id', $order->dashboard_order_id)->get();
            foreach($history as $entry) {
                $entry->delete();
            }
        }

        return redirect()->to($request->last_url)->with('success', 'Order '. $order->dashboard_order_id .' edited. '.$response);
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

        $response = "";
        if($order->order_status == 'Completed') {
            $this->freeBikes($order);
            $this->deleteEvent($order);
        } else if($order->order_status == 'Archived'){
            if($this::ENABLE_SMS) {
                $sms = new SmsController(new ClicksendService());
                $result = $sms->sendSMS($order->mobile, SmsController::getReturnMessage());

                if($result == 1) {
                    $response = "Sms sent!";
                } else {
                    $response = "Couldn't send sms, Invalid phone number";
                }
            }
        } else if ($order->order_status == 'Cancelled') {
            $this->freeBikes($order);
            $this->deleteEvent($order);

            $history = BikesDashboardOrder::where('order_id', $order->dashboard_order_id)->get();
            foreach($history as $entry) {
                $entry->delete();
            }
        }

        return redirect()->back()->with('success', 'Status of '. $order->dashboard_order_id .' edited. '.$response);
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





    public function archive(Request $request) {
        $orders =  DashboardOrder::where('order_status', 'Archived')->with('history')->orderByDesc('created_at')
        ->paginate(50);
        if($request->search != null) {
            $orders = $this->searchOrders($request->search, true);
        }
        return view('orders.archive', [
            'orders' => $orders,
            'search' => $request->search
        ]);
    }

    public function home() {
        $types = array();
        $bikeTypes = ['Cruiser', 'Urban', 'Kid'];
        foreach($bikeTypes as $type) {
            foreach(BikeColor::all() as $color) {
                $bikeFigures = Bike::where('type', 'LIKE', $type)->where('color','LIKE',$color['value'])
                ->where('status', "NOT LIKE", 'archive')->get();
                if(count($bikeFigures) > 0) {
                    $types[] = $bikeFigures;
                }
            }
        }

        $todaySales = UtilController::getTodaysSales();
        $weekSales = UtilController::getWeekSales();
        $monthSales = UtilController::getMonthSales();
        $yearSales = UtilController::getYearSales();
        $totalSales = UtilController::getTotalSales();
        
        $allIn = Bike::where('status', 'LIKE', 'in')->count();
        $allOut = Bike::where('status', 'LIKE', 'out')->count();
        $all = Bike::count();

        $bikesInLocations = UtilController::getBikeStats(Location::all());

        return view('home',[
            'types' => $types,

            'todaySales' => $todaySales,
            'weekSales' => $weekSales,
            'monthSales' => $monthSales,
            'yearSales' => $yearSales,
            'totalSales'=> $totalSales,

            'all' => $all,
            'allIn' => $allIn,
            'allOut' => $allOut,

            'bikes' => $bikesInLocations
        ]);
    }

    public function prePickup(DashboardOrder $order) {
        $response = "";
        if($this::ENABLE_SMS) {
            $sms = new SmsController(new ClicksendService());
            $response = $sms->sendSMS($order->mobile, SmsController::getMessageStartDate());

            if($response == 1) {
                $order->start_date_sms = 1;
                $order->save();
                return redirect('/')->with('success', 'Sms sent!');
            } else {
                return redirect('/')->with('error', "Couldn't send SMS");
            }
            
        }
    }

    public function reminder(DashboardOrder $order) {
        $response = "";
        if($this::ENABLE_SMS) {
            $sms = new SmsController(new ClicksendService());
            $response = $sms->sendSMS($order->mobile, SmsController::getMessageEndDate());

            if($response == 1) {
                $order->end_date_sms = 1;
                $order->save();
                return redirect('/')->with('success', 'Sms sent!');
            } else {
                return redirect('/')->with('error', "Couldn't send SMS, invalid phone number");
            }
        }
    }
    
    public function promo(DashboardOrder $order) {
        $response = "";
        if($this::ENABLE_SMS) {
            $sms = new SmsController(new ClicksendService());
            $response = $sms->sendSMS($order->mobile, SmsController::getPromoMessage());

            if($response == 1) {
                $order->promo_sms = 1;
                $order->save();
                return redirect('/')->with('success', 'Sms sent!');
            } else {
                return redirect('/')->with('error', "Couldn't send SMS, invalid phone number");
            }
        }
    }
}
