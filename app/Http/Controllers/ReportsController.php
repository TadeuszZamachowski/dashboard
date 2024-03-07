<?php

namespace App\Http\Controllers;

use App\Models\DashboardOrder;
use App\Models\Location;
use App\Models\Bike;
use App\Models\BikeColor;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\Http\Controllers\UtilController;

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

    public function bikesStatistics() {
        return view('reports.bikesByTypeResult', [
            'locations' => Location::all(),
            'colors' => BikeColor::all() ,
        ]);
    }

    public function graph() {
        $chart_options = [
            'chart_color' => '255,0,0',
            'chart_title' => 'Assigned bikes',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\BikeNumber',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'count',
            'chart_type' => 'line',
        ];
        $chart1 = new LaravelChart($chart_options);
        
        return view('reports.graph', compact('chart1'));
    }
}
