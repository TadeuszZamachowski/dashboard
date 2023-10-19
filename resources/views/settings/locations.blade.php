@extends('layout')
@section('content')
<h1>Locations</h1>
<form method="POST" action="/settings/locations">
    @csrf
    <label for="value">Location:</label><br>
    <input type="text" id="value" name="value" value="{{old('value')}}"><br>
    @error('value')
        <p>{{$message}}</p>
    @enderror
    <input type="submit" value="Add">
</form>

<table style="margin-bottom:20px">
    <thead>
    <tr>
        <th>Value</th>
        <th>Delete</th>
    </tr>
    </thead>
@foreach ($locations as $location)
    <tbody>
        <tr>
            <td>{{$location->value}}</td>
            <td>
                <form method="POST" action="/settings/locations/{{$location->id}}">
                @csrf
                @method('DELETE')
                <button><i class="fa-solid fa-trash" style="color: #000000;"></i></button>
                </form>
            </td>
        </tr>
    </tbody>
@endforeach
@endsection