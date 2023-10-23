<?php

namespace App\Http\Controllers;

use App\Models\DashboardOrder;
use App\Models\Post;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashboardOrderController extends Controller
{
    public function index() {
        return view('orders.index', [
            'orders' => DashboardOrder::orderByDesc('dashboard_order_id')->get()
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
        $data['order_status'] = 'Processing';
        $data['pickup_location'] = $request['pickup_location'];
        $data['number_of_bikes'] = $request['number_of_bikes'];
        
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

    public function destroy(DashboardOrder $order) {
        $order->delete();
        return redirect('/')->with('success', 'Order deleted succesfully');
    }
}
