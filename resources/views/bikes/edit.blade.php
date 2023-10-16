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

    <input type="submit" value="Submit">
</form>
@endsection