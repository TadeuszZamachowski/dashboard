@extends('layout')
@section('content')
<h1>Result</h1>
<h3>Orders from {{$from}} to {{$to}} in {{$location}}</h3>
@php
    $total = 0;
@endphp
@foreach ($orders as $order)
    <p>Order: {{$order->dashboard_order_id}} {{$order->first_name}} | Amount: ${{$order->amount_paid}}</p>
    @php
        $total += $order->amount_paid
    @endphp
@endforeach
<h3>Total: ${{$total}}</h3>
    
@endsection