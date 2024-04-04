@extends('layout')
@section('content')
<h1>Accomodations</h1>

<div class="order-create">
    <div class="left-side">
        <form method="POST" action="/settings/accommodations">
            @csrf
                <label for="value">Name:</label><br>
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
        @foreach ($accommodations as $acc)
            <tbody>
                <tr>
                    <td>{{$acc->value}}</td>
                    <td>
                        <form method="POST" action="/settings/accommodations/{{$acc->id}}">
                        @csrf
                        @method('DELETE')
                        <button><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            </tbody>
        @endforeach
        </table>
    </div>
</div>
@endsection