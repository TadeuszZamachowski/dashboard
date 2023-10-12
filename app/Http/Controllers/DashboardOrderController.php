<?php

namespace App\Http\Controllers;

use App\Models\DashboardOrder;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashboardOrderController extends Controller
{
    public function index() {
        return view('orders.index', [
            'orders' => DashboardOrder::orderByDesc('id')->get()
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
            'order_status' => 'required',
            'pickup_location' => 'required',
        ]);

        $data['id'] = DashboardOrder::max('id') + 1;
        $data['first_name'] = $request['first_name'];
        $data['last_name'] = $request['last_name'];
        $data['email'] = $request['email'];
        $data['mobile'] = $request['mobile'];
        $data['start_date'] = $request['start_date'];
        $data['end_date'] = $request['end_date'];
        $data['amount_paid'] = $request['amount_paid'];
        $data['order_status'] = $request['order_status'];
        $data['pickup_location'] = $request['pickup_location'];
        
        DashboardOrder::create($data);

        return redirect('/')->with('success', 'Order succesfully added.');
    }

    public function edit(DashboardOrder $order) {
        return view('orders.edit', ['order' => $order]);
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
        
        $order->update($data);

        return redirect('/orders/'.$order->id)->with('success', 'Order succesfully updated.');
    }

    public function destroy(DashboardOrder $order) {
        $order->delete();
        return redirect('/')->with('success', 'Order deleted succesfully');
    }
}
