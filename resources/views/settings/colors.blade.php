@extends('layout')
@section('content')
<h1>Colors</h1>

<div class="order-create">
    <div class="left-side">
        <form method="POST" action="/settings/colors">
            @csrf
                <label for="value">Color:</label><br>
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
        @foreach ($colors as $color)
            <tbody>
                <tr>
                    <td>{{$color->value}}</td>
                    <td>
                        <form method="POST" action="/settings/colors/{{$color->id}}">
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