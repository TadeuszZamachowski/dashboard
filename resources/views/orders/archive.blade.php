@extends('layout')
@section('content')
<table id="orders-table" class="orders-table">
    <thead>
    <tr>
        <th>Order ID</th>
        <th>Name</th>
        <th>Phone number</th>
        <th>Start Date</th>
        <th>Duration</th>
        <th>Amount</th>
        <th>Status</th>
        <th>Pickup</th>
        <th style="padding-right: 10px">Bikes</th>
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
        <td>{{"$".$order->amount_paid}}</td>
        <td>{{$order->order_status}}</td>

        <td>{{$order->pickup_location}}</td>
        <td>{{$order->number_of_bikes}}</td>
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