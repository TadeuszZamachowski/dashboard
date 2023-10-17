@extends('layout')
@section('content')

<h2> {{$order->dashboard_order_id}}</h2>
<p>Pickup Location: {{$order->pickup_location}}</p>


@endsection
