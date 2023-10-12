@extends('layout')
<style>
    button {
        margin-left: 32px;
        margin-top: 10px;
        font-size: 25px;
        background: none!important;
        border: none;
        padding: 0!important;
        /*optional*/
        font-family: arial, sans-serif;
        /*input has OS specific font-family*/
        color: black;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        color: #a36464;
    }
</style>
<div id="mySidenav" class="sidenav">
    <a href="/"><img src="\images\RGB-LOGO-BYRON-BAY-BIKES.png" alt="Logo" width="150px"></a>
    <a href="/orders/add">Add Order</a>
    <a href="/orders/{{$order->id}}/edit">Edit Order</a>
    <form method="POST" action="/orders/{{$order->id}}">
        @csrf
        @method('DELETE')
        <button>Delete Order</button>
    </form>
    <a href="#">Assign Bike to Order</a>
  </div>
@section('content')

<h2> {{$order->id}}</h2>
<p>Pickup Location: {{$order->pickup_location}}</p>


@endsection
