<?php

namespace App\Http\Controllers;

use App\Models\DashboardOrder;
use App\Models\Location;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index() {
        return view("reports.index");
    }

    public function salesByLocation() {
        return view("reports.salesByLocation", [
            'locations' => Location::all()
        ]);
    }

    public function process(Request $request) {
        $from = date("Y-m-d",strtotime($request->from));
        $to = date("Y-m-d",strtotime($request->to));
        $orders = DashboardOrder::whereBetween('created_at', [$from, $to])
                                ->where('pickup_location', 'LIKE', $request->location)->get();
        return view('reports.result', [
            'from' => $request->from,
            'to' => $request->to,
            'location' => $request->location,
            'orders' => $orders
        ]);
    }

    public function graph() {
        return view('reports.graph');
    }
}
