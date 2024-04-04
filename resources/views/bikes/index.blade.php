@extends('layout')

@section('content')
<div class="sorting-section" style="margin-bottom: 20px">
    <div class="filter-selector">
        <form method="GET" action="/bikes">
            <select onchange="this.form.submit()" name="filter" id="filter">
                <option selected="selected">{{$filter}}</option>
                @foreach ($categories as $item)
                    @if ($item->value == $filter)
                        {{-- Don't display duplicates --}}
                    @else
                        <option value="{{$item->value}}">{{$item->value}} </option>
                    @endif
                @endforeach
                <option value="None">None</option>
            </select>
        </form>
    </div>

    <div class="search-bar">
        <div class="in" style="padding-right: 20px">
            Bikes in = {{$in}}
        </div>
        <div class="out" style="padding-right: 20px">
            Bikes out = {{$out}}
        </div>
        <div class="total" style="padding-right: 20px">
            Total = {{$total}}
        </div>
    </div>
</div>

<a class="btn" href="/bikes/add">Add Bike</a>
<h1 style="padding-top: 20px">Bikes In</h1>
<table id="orders-table" class="bikes-table">
    <thead>
    <tr>
        {{-- sortTable(n, isStatus, isLink, isDate, isNum) --}}
        <th onclick="sortTable(2,0,0,0,1)">ID</th>
        <th onclick="sortTable(3,0,0,0,1)">Number</th>
        <th onclick="sortTable(4,0,1,0,1)">Code</th>
        <th onclick="sortTable(5,0,0,0,0)">Color</th>
        <th onclick="sortTable(6,0,0,0,0)">Type</th>
        <th onclick="sortTable(7,0,0,0,0)">Accessory</th>
        <th onclick="sortTable(8,0,0,0,0)">Location</th>
        <th onclick="sortTable(10,0,0,0,1)">Order ID</th>
        <th onclick="sortTable(11,0,0,0,0)">Name</th>
        <th onclick="sortTable(12,0,0,1,0)">Return Date</th>
        <th onclick="sortTable(13,0,0,0,1)">$</th>
        <th onclick="sortTable(14,0,0,0,1)">Total Duration</th>
        <th onclick="sortTable(12,0,0,1,0)">Checked</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    </thead>
@foreach ($bikes as $bike)
    @php
        $date = optional($bike->dashboardOrder)->end_date;
        if($date != null) {
            $frmtDate = date('d-m-Y (g A)',strtotime($date));
        } else {
            $frmtDate = "";
        }

        $salesTotal = 0;
        $durationTotal = 0;
        $history = App\Models\BikesDashboardOrder::where('bike_id', $bike->id)->get();
        foreach($history as $entry) {
            $date1 = new DateTime($entry->start_date);
            $date2 = new DateTime($entry->end_date);
            $interval = $date1->diff($date2);
            $duration = $interval->days;

            $order = App\Models\DashboardOrder::where('dashboard_order_id', $entry->order_id)->first();
            $salesTotal += $order->amount_paid;
            $durationTotal += $duration;
        }
    
        $latestCheckDate = '';
        if(count($bike->bikeChecks) > 0) {
            $sorted = $bike->bikeChecks->sortByDesc('created_at');
            $foundCheck = $sorted->first();
            $latestCheckDate = date('d-m-Y',strtotime($foundCheck->created_at));
        }
    @endphp
    <tbody>
        @if ($bike['status'] == 'in')
            <tr @class([
                'bike-in' => ($bike['status'] == 'in' || $bike['status'] == 'In'),
                'bike-out' => ($bike['status'] == 'out' || $bike['status'] == 'Out'),
                'bike-free' => $bike['status'] == 'free',
                'bike-repair' => $bike['state'] == 'repair' || $bike['status'] == 'Repair',
                'bike-sell' => $bike['status'] == 'sell',
                'due-date' => (optional($bike->dashboardOrder)->order_status == 'Assigned') && 
                                (date('Y-m-d H:i:s', strtotime(optional($bike->dashboardOrder)->end_date)) < date('Y-m-d H:i:s')),
                
            ])>
                <td><a href="/bikes/{{$bike['id']}}">{{$bike['id']}}</a></td>
                <td>{{$bike['number']}}</td>
                <td>{{$bike['code']}}</a></td>
                <td>{{$bike['color']}}</td>
                <td>{{$bike['type']}}</td>
                <td>{{$bike['accessory']}}</td>
                <td>{{$bike['location']}}</td>
                <td>
                    <a href="orders/{{$bike['dashboard_order_id']}}">
                        {{$bike['dashboard_order_id']}}</a></td>
                <td>{{optional($bike->dashboardOrder)->first_name}}</td>
                <td>{{$frmtDate}}</td>
                <td>{{$salesTotal}}</td>
                <td>{{$durationTotal}}</td>
                <td>{{$latestCheckDate}}</td>
                <td>
                    <a href="/bikes/{{$bike->id}}/assign">
                        <i class="fa-solid fa-bicycle" style="color: black">
                        </i>
                    </a>
                </td>
                <td>
                    <a href="/bikes/{{$bike->id}}/edit"><i class="fas fa-edit" style="color: #000000;"></i></a>            
                </td>
                <td>
                    <form method="POST" action="/bikes/{{$bike->id}}">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa-solid fa-trash" style="color: #000000;"></i></button>
                    </form>
                </td>
                <td>
                    <form method="GET" action="/bikes/check/{{$bike->id}}">
                        @csrf
                        <button><i class="fas fa-tools"></i></button>
                    </form>
                </td>
            </tr>
        @endif
    </tbody>
    
@endforeach
</table>
<h1>Bikes Out</h1>
<table id="orders-table" class="bikes-table">
    <thead>
    <tr>
        {{-- sortTable(n, isStatus, isLink, isDate, isNum) --}}
        <th onclick="sortTable(2,0,0,0,1)">ID</th>
        <th onclick="sortTable(3,0,0,0,1)">Number</th>
        <th onclick="sortTable(4,0,1,0,1)">Code</th>
        <th onclick="sortTable(5,0,0,0,0)">Color</th>
        <th onclick="sortTable(6,0,0,0,0)">Type</th>
        <th onclick="sortTable(7,0,0,0,0)">Accessory</th>
        <th onclick="sortTable(8,0,0,0,0)">Location</th>
        <th onclick="sortTable(10,0,0,0,1)">Order ID</th>
        <th onclick="sortTable(11,0,0,0,0)">Name</th>
        <th onclick="sortTable(12,0,0,1,0)">Return Date</th>
        <th onclick="sortTable(13,0,0,0,1)">$</th>
        <th onclick="sortTable(14,0,0,0,1)">Total Duration</th>
        <th onclick="sortTable(12,0,0,1,0)">Checked</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    </thead>
@foreach ($bikes as $bike)
    @php
        $date = optional($bike->dashboardOrder)->end_date;
        if($date != null) {
            $frmtDate = date('d-m-Y (g A)',strtotime($date));
        } else {
            $frmtDate = "";
        }

        $salesTotal = 0;
        $durationTotal = 0;
        $history = App\Models\BikesDashboardOrder::where('bike_id', $bike->id)->get();
        foreach($history as $entry) {
            $date1 = new DateTime($entry->start_date);
            $date2 = new DateTime($entry->end_date);
            $interval = $date1->diff($date2);
            $duration = $interval->days;

            $order = App\Models\DashboardOrder::where('dashboard_order_id', $entry->order_id)->first();
            $salesTotal += $order->amount_paid;
            $durationTotal += $duration;
        }
    
        $latestCheckDate = '';
        if(count($bike->bikeChecks) > 0) {
            $sorted = $bike->bikeChecks->sortByDesc('created_at');
            $foundCheck = $sorted->first();
            $latestCheckDate = date('d-m-Y',strtotime($foundCheck->created_at));
        }
    @endphp
    <tbody>
        @if ($bike['status'] == 'out')
            <tr @class([
                'bike-in' => ($bike['status'] == 'in' || $bike['status'] == 'In'),
                'bike-out' => ($bike['status'] == 'out' || $bike['status'] == 'Out'),
                'bike-free' => $bike['status'] == 'free',
                'bike-repair' => $bike['state'] == 'repair' || $bike['status'] == 'Repair',
                'bike-sell' => $bike['status'] == 'sell',
                'due-date' => (optional($bike->dashboardOrder)->order_status == 'Assigned') && 
                                (date('Y-m-d H:i:s', strtotime(optional($bike->dashboardOrder)->end_date)) < date('Y-m-d H:i:s')),
                
            ])>
                <td><a href="/bikes/{{$bike['id']}}">{{$bike['id']}}</a></td>
                <td>{{$bike['number']}}</td>
                <td>{{$bike['code']}}</a></td>
                <td>{{$bike['color']}}</td>
                <td>{{$bike['type']}}</td>
                <td>{{$bike['accessory']}}</td>
                <td>{{$bike['location']}}</td>
                <td>
                    <a href="orders/{{$bike['dashboard_order_id']}}">
                        {{$bike['dashboard_order_id']}}</a></td>
                <td>{{optional($bike->dashboardOrder)->first_name}}</td>
                <td>{{$frmtDate}}</td>
                <td>{{$salesTotal}}</td>
                <td>{{$durationTotal}}</td>
                <td>{{$latestCheckDate}}</td>
                <td>
                    <a href="/bikes/{{$bike->id}}/assign">
                        <i class="fa-solid fa-bicycle" style="color: black">
                        </i>
                    </a>
                </td>
                <td>
                    <a href="/bikes/{{$bike->id}}/edit"><i class="fas fa-edit" style="color: #000000;"></i></a>            
                </td>
                <td>
                    <form method="POST" action="/bikes/{{$bike->id}}">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa-solid fa-trash" style="color: #000000;"></i></button>
                    </form>
                </td>
                <td>
                    <form method="GET" action="/bikes/check/{{$bike->id}}">
                        @csrf
                        <button><i class="fas fa-tools"></i></button>
                    </form>
                </td>
            </tr>
        @endif
    </tbody>
@endforeach
</table>
<script>$(document).ready(function () {
    $('tr').click(function () {
        if($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        }
        else {
            $(this).addClass('selected');
        }
    });
  });</script>
@endsection
