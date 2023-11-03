@extends('layout')
@section('content')
<table id="orders-table" class="orders-table">
    <thead>
    <tr>
        {{-- sortTable(n, isStatus, isLink, isDate, isNum) --}}
        <th onclick="sortTable(0,0,1,0,1)">Order ID</th>
        <th onclick="sortTable(1,0,0,0,0)">Name</th>
        <th onclick="sortTable(2,0,0,0,1)">Phone number</th>
        <th onclick="sortTable(3,0,0,1,0)">Start Date</th>
        <th onclick="sortTable(4,0,0,0,1)">Duration</th>
        <th onclick="sortTable(5,0,0,0,1)">$</th>
        <th onclick="sortTable(6,0,0,0,0)">Status</th>
        <th onclick="sortTable(7,0,0,0,0)">Pickup</th>
        <th onclick="sortTable(8,0,0,0,1)">Bikes</th>
    </tr>
    </thead>
@php
    $even = false;
@endphp
@foreach ($orders as $order)
    @php
        $frmtStartDate = date('d-m-Y',strtotime($order->start_date));
        $frmtEndDate = date('d-m-Y',strtotime($order->end_date));
        $date1 = new DateTime($order->start_date);
        $date2 = new DateTime($order->end_date);
        $interval = $date1->diff($date2);
        $duration = $interval->days;
    @endphp
    <tbody>
    <tr @class([
        'even' => $even == true,
        'due-date' => ($order->order_status == 'Processing') && (date('Y-m-d H:i:s', strtotime($order->end_date)) < date('Y-m-d H:i:s'))
    ])>
        <td><a href="/orders/archive/{{$order->dashboard_order_id}}">{{$order->dashboard_order_id}}</a></td>
        <td>{{$order->first_name}} {{$order->last_name}}</td>
        <td>{{$order->mobile}}</td>
        <td nowrap>{{$frmtStartDate}}</td>
        <td nowrap>{{$duration}} days</td>
        <td>{{$order->amount_paid}}</td>
        <td>{{$order->order_status}}</td>

        <td>{{$order->pickup_location}}</td>
        <td>
            <div class="tooltip">
                <i class="fa-solid fa-bicycle" style="color: green"></i>
                <span class="tooltiptext">
                    @foreach ($history as $entry)
                        @if($entry->order_id == $order->dashboard_order_id)
                            @foreach ($bikes as $bike)
                            @if($bike->id == $entry->bike_id)
                                Rack {{$bike->rack}} | Code: {{$bike->code}} <br>
                            @endif
                            @endforeach
                        @endif
                    @endforeach   
                </span>
            </div>
        </td>
    </tr>
    </tbody>
    @php
        if($even == true) {
            $even = false;
        } else {
            $even = true;
        }
    @endphp
@endforeach
</table>
<div class="pagination">
    {{ $orders->onEachSide(1)->links() }}
</div>
@endsection