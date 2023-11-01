@extends('layout')
@section('content')
@php
    $frmtStartDate = date('d-m-Y',strtotime($order->start_date));
    $frmtEndDate = date('d-m-Y',strtotime($order->end_date));
@endphp
<div class="show-order">
    <div class="left-side">
        <h2> {{$order->dashboard_order_id}}</h2>
        <h3>Start Date: {{$frmtStartDate}}</h3>
        <h3>End Date: {{$frmtEndDate}}</h3>
        <h3>Amount Paid: ${{$order->amount_paid}}</h3>
        <p>First Name: {{$order->first_name}}</p>
        <p>Last Name: {{$order->last_name}}</p>
        <p>Email: {{$order->email}}</p>
        <p>Mobile: {{$order->mobile}}</p>
        <p>Pickup Location: {{$order->pickup_location}}</p>
        <p>Number of Bikes: {{$order->number_of_bikes}}</p>
        <p>Status: {{$order->order_status}}</p>
        <p>Payment method: {{$order->payment_method}}</p>
    </div>
    @if($archive == true)
        <div class="right-side">
            <h2>{{count($bikes)}} Bikes:</h2>
            @foreach($bikes as $bike)
                <p>{{$bike->color}} {{$bike->type}}</p>
                <p>Rack: {{$bike->rack}} | Code: {{$bike->code}}</p>
                <p>Accessory: {{$bike->accessory}} | Location: {{$bike->location}}</p>
                <br>
            @endforeach
        </div>
    @endif
</div>


@endsection
