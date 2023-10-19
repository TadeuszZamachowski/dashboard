@extends('layout')


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
    <label for="color">Color:</label><br>
    <input type="text" id="color" name="color" value="{{old('color')}}"><br>
    @error('color')
        <p>{{$message}}</p>
    @enderror

    <label for="type">Type:</label><br>
    <input type="text" id="type" name="type" value="{{old('type')}}"><br>
    @error('type')
        <p>{{$message}}</p>
    @enderror

    <label for="gear">Gear:</label><br>
    <input type="text" id="gear" name="gear" value="{{old('gear')}}"><br>
    @error('gear')
        <p>{{$message}}</p>
    @enderror

    <label for="accessory">Accessory:</label><br>
    <input type="text" id="accessory" name="accessory" value="{{old('accessory')}}"><br>
    @error('accessory')
        <p>{{$message}}</p>
    @enderror

    <label for="code">Code:</label><br>
    <input type="text" id="code" name="code" value="{{old('code')}}"><br>
    @error('code')
        <p>{{$message}}</p>
    @enderror

    <label for="location">Location:</label><br>
    <input type="text" id="location" name="location" value="{{old('location')}}"><br>
    @error('location')
        <p>{{$message}}</p>
    @enderror

    <label for="rack">Rack:</label><br>
    <input type="text" id="rack" name="rack" value="{{old('rack')}}"><br>
    @error('rack')
        <p>{{$message}}</p>
    @enderror

    <label for="status">Status:</label><br>
    <input type="text" id="status" name="status" value="{{old('status')}}"><br>
    @error('status')
        <p>{{$message}}</p>
    @enderror

    <input type="submit" value="Submit">
</form>
@endsection