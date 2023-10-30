@extends('layout')
@section('content')
<h1 style="color:red">Bikes already assigned to this order</h1>
<h2>Assigned bikes:</h2>
@foreach($bikes as $bike)
    <p>{{$bike->color}}, Code - {{$bike->code}}, Rack - {{$bike->rack}}</p>
@endforeach
<p style="color: rgb(233, 0, 0)">Reassigning cancels the current assignement</p>
<br>
<form method="GET" action="/orders/{{$order->dashboard_order_id}}/assign">
    <input type="hidden" name="reassign" value="true">
    <button class="btn" type="submit">Reassign</button>
</form>
@endsection