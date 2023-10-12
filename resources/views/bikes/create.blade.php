@extends('layout')
@extends('bikes.side-bikes')

@section('content')
<style>
    p {
        color: red;
        font-size: 12px;
    }
</style>
<h1>Add a bike</h1>
<form method="POST" action="/bikes">
    @csrf
    <label for="rack">Rack:</label><br>
    <input type="text" id="rack" name="rack" value="{{old('rack')}}"><br>
    @error('rack')
        <p>{{$message}}</p>
    @enderror

    <label for="code">Code:</label><br>
    <input type="text" id="code" name="code" value="{{old('code')}}"><br>
    @error('code')
        <p>{{$message}}</p>
    @enderror

    <label for="name">Description:</label><br>
    <input type="text" id="name" name="name" value="{{old('name')}}"><br>
    @error('name')
        <p>{{$message}}</p>
    @enderror

    <label for="status">Status:</label><br>
    <input type="text" id="status" name="status" value="{{old('status')}}"><br>
    @error('status')
        <p>{{$message}}</p>
    @enderror

    <label for="location">Location:</label><br>
    <input type="text" id="location" name="location" value="{{old('location')}}"><br>
    @error('status')
        <p>{{$message}}</p>
    @enderror

    <label for="order_id">Order ID:</label><br>
    <input type="text" id="order_id" name="order_id" value="{{old('order_id')}}"><br>

    <input type="submit" value="Submit">
</form>


@endsection