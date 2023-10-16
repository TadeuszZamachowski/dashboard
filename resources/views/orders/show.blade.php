@extends('layout')
@section('content')

<h2> {{$order->id}}</h2>
<p>Pickup Location: {{$order->pickup_location}}</p>


@endsection
