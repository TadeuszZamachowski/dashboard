@extends('layout')
@section('content')
<h1>Racks</h1>

<div class="order-create">
    <div class="left-side">
        <form method="POST" action="/settings/racks">
            @csrf
                <label for="value">Rack:</label><br>
                <input type="text" id="value" name="value" value="{{old('value')}}"><br>
                @error('value')
                    <p>{{$message}}</p>
                @enderror
                <input class="btn" type="submit" value="Add">
        </form>
    </div>
    <div class="right-side">
        <table style="margin-bottom:20px">
            <thead>
            <tr>
                <th>Value</th>
                <th>Delete</th>
            </tr>
            </thead>
        @foreach ($racks as $rack)
            <tbody>
                <tr>
                    <td>{{$rack->value}}</td>
                    <td>
                        <form method="POST" action="/settings/racks/{{$rack->id}}">
                        @csrf
                        @method('DELETE')
                        <button><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            </tbody>
        @endforeach
    </div>
</div>
@endsection