@extends('layout')
@section('content')

<h2> {{$order->dashboard_order_id}}</h2>
<h3>Start Date: {{$order->start_date}}</h3>
<h3>End Date: {{$order->end_date}}</h3>
<h3>Amount Paid: ${{$order->amount_paid}}</h3>
<p>First Name: {{$order->first_name}}</p>
<p>Last Name: {{$order->last_name}}</p>
<p>Email: {{$order->email}}</p>
<p>Mobile: {{$order->mobile}}</p>
<p>Pickup Location: {{$order->pickup_location}}</p>
<p>Number of Bikes: {{$order->number_of_bikes}}</p>
<p>Status: {{$order->order_status}}</p>


@endsection
