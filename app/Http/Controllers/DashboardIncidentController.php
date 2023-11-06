<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\DashboardIncident;
use App\Models\DashboardOrder;
use Illuminate\Http\Request;

class DashboardIncidentController extends Controller
{
    public function index() {
        return view("incidents.index", [
            'incidents' => DashboardIncident::paginate(10)
        ]);
    }

    public function create() {
        return view('incidents.create', [
            'orders' => DashboardOrder::all()->sortByDesc('dashboard_order_id'),
            'bikes' => Bike::all()->sortBy('rack')
        ]);
    }

    public function store(Request $request) {
        $validation = $request->validate([
            'date' => 'required',
            'dashboard_order_id' => 'required',
            'bike_id' => 'required',
            'report' => 'required',
            'action'=> 'required'
        ]);
        
        DashboardIncident::create($validation);

        return redirect('/incidents')->with('success', 'Incident succesfully added.');
    }

    public function edit(DashboardIncident $incident) {
        return view('incidents.edit', [
            'incident' => $incident,
            'orders' => DashboardOrder::all()->sortByDesc('dashboard_order_id'),
            'bikes' => Bike::all()->sortBy('rack')
        ]);
    }

    public function update(Request $request, DashboardIncident $incident) {
        $validation = $request->validate([
            'date' => 'required',
            'dashboard_order_id' => 'required',
            'bike_id' => 'required',
            'report' => 'required',
            'action'=> 'required'
        ]);
        
        $incident->update($validation);

        return redirect('/incidents')->with('success', 'Incident updated.');
    }

    public function destroy(DashboardIncident $incident) {
        $incident->delete();

        return redirect('/incidents')->with('success', 'Incident deleted.');
    }
}
