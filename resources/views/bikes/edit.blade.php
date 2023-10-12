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
    <a href="/bikes/add">Add Bike</a>
    <a href="/bikes/{{$bike['id']}}/edit">Edit Bike</a>
    <form method="POST" action="/bikes/{{$bike->id}}">
        @csrf
        @method('DELETE')
        <button>Delete Bike</button>
    </form>
  </div>

@section('content')
<style>
    p {
        color: red;
        font-size: 12px;
    }
</style>
<h1>Edit a bike</h1>
<form method="POST" action="/bikes/{{$bike->id}}">
    @csrf
    @method('PUT')
    <label for="rack">Rack:</label><br>
    <input type="text" id="rack" name="rack" value="{{$bike->rack}}"><br>
    @error('rack')
        <p>{{$message}}</p>
    @enderror

    <label for="code">Code:</label><br>
    <input type="text" id="code" name="code" value="{{$bike->code}}"><br>
    @error('code')
        <p>{{$message}}</p>
    @enderror

    <label for="name">Description:</label><br>
    <input type="text" id="name" name="name" value="{{$bike->name}}"><br>
    @error('name')
        <p>{{$message}}</p>
    @enderror

    <label for="status">Status:</label><br>
    <input type="text" id="status" name="status" value="{{$bike->status}}"><br>
    @error('status')
        <p>{{$message}}</p>
    @enderror

    <label for="location">Location:</label><br>
    <input type="text" id="location" name="location" value="{{$bike->location}}"><br>
    @error('status')
        <p>{{$message}}</p>
    @enderror

    <label for="order_id">Order ID:</label><br>
    <input type="text" id="order_id" name="order_id" value="{{$bike->order_id}}"><br>

    <input type="submit" value="Submit">
</form>
@endsection