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
                        <option value={{$item->value}}>{{$item->value}} </option>
                    @endif
                @endforeach
                <option value="None">None</option>
            </select>
        </form>
    </div>
</div>

<a class="btn" href="/bikes/add">Add Bike</a>
<table id="orders-table" class="bikes-table">
    <thead>
    <tr>
        {{-- sortTable(n, isStatus, isLink, isDate, isNum) --}}
        <th></th>
        <th onclick="sortTable(1,0,0,0,1)">Rack</th>
        <th onclick="sortTable(2,0,0,0,1)">ID</th>
        <th onclick="sortTable(3,0,0,0,1)">Number</th>
        <th onclick="sortTable(4,0,1,0,1)">Code</th>
        <th onclick="sortTable(5,0,0,0,0)">Color</th>
        <th onclick="sortTable(6,0,0,0,0)">Type</th>
        <th onclick="sortTable(7,0,0,0,0)">Accessory</th>
        <th onclick="sortTable(8,0,0,0,0)">Location</th>
        <th onclick="sortTable(9,0,0,0,0)">Status</th>
        <th onclick="sortTable(10,0,0,0,1)">Order ID</th>
        <th onclick="sortTable(11,0,0,0,0)">Name</th>
        <th onclick="sortTable(12,0,0,1,0)">Return Date</th>
        <th onclick="sortTable(13,0,0,0,1)">$</th>
        <th onclick="sortTable(14,0,0,0,1)">Total Duration</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    @foreach ($racks as $rack)
        @php
            $bike = optional($rack->bike);
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
        @endphp
        <tbody>
            <tr @class([
                'bike-in' => $bike->status == 'in',
                'bike-out' => $bike->status == 'out',
                'bike-free' => $bike->status == 'free',
                'bike-repair' => $bike->status == 'repair',
                'bike-sell' => $bike->status == 'sell',
                'due-date' => (optional($bike->dashboardOrder)->order_status == 'Assigned') && 
                            (date('Y-m-d H:i:s', strtotime(optional($bike->dashboardOrder)->end_date)) < date('Y-m-d H:i:s'))
            ])>
                @if ($bike->color == null)
                    <td style="border-right: solid 1px; ">
                        <a href="/bikes/boundToRack/{{$rack->id}}"><i class="fa-solid fa-plus"></i></a>
                    </td>
                @else
                    <td style="border-right: solid 1px; ">
                        <a href="/bikes/freeRack/{{$rack->id}}"><i class="fa-solid fa-minus"></i></a>
                    </td>
                @endif
                <td>{{$rack->value}}</td>
                <td>{{$bike->id}}</td>
                <td>{{$bike->number}}</td>
                <td><a href="/bikes/{{$bike->id}}">{{$bike->code}}</a></td>
                <td>{{$bike->color}}</td>
                <td>{{$bike->type}}</td>
                <td>{{$bike->accessory}}</td>
                <td>{{$bike->location}}</td>
                <td>{{$bike->status}}</td>
                <td>
                    <a href="orders/{{$bike->dashboard_order_id}}">
                        {{$bike->dashboard_order_id}}</a>
                </td>
                <td>{{optional($bike->dashboardOrder)->first_name}}</td>
                <td>{{$frmtDate}}</td>
                <td>${{$salesTotal}}</td>
                <td>{{$durationTotal}} days</td>
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
                    <form method="POST" action="/bikes/check/{{$bike->id}}">
                        @csrf
                        <button><i class="fa-solid fa-check"></i></button>
                    </form>
                </td>
            </tr>
        </tbody>
        {{-- Black stripe after rack 15 --}}
        @if($rack->value == 21) 
            <tr style="background-color: black;">
                @for ($i = 17; $i > 0; $i--)
                    <td style="padding: 30px"></td>
                @endfor
            </tr>
        @endif
    @endforeach
</table>
@endsection
