@extends('layout')
@section('content')

<h1>DASHBOARD</h1>
<div class="total-bikes">
    <p>Total bikes: {{$all}}</p>
    <p>In: {{$allIn}}</p>
    <p>Out: {{$allOut}}</p>
</div>
<br>

<div class="mercato-bikes">
    <p>Mercato bikes: {{$mercato}}</p>
    <p>In: {{$mercatoIn}}</p>
    <p>Out: {{$mercatoOut}}</p>
</div>
<br>

<div class="suffolk-bikes">
    <p>Suffolk bikes: {{$suffolk}}</p>
    <p>In: {{$suffolkIn}}</p>
    <p>Out: {{$suffolkOut}}</p>
</div>
<br>

<div class="airbnb-bikes">
    <p>Airbnb bikes: {{$airbnb}}</p>
    <p>In: {{$airbnbIn}}</p>
    <p>Out: {{$airbnbOut}}</p>
</div>
<br>

<div class="sales">
    <p>Total sales: ${{$totalSales}}</p>
</div>

@endsection