@extends('layout')
@section('content')
<h1>Add Quick Order</h1>
<form method="POST" action="/orders/add-quick">
    @csrf
    <div class="input-section">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" value="{{old('first_name')}}">
        @error('first_name')
            <p>{{$message}}</p>
        @enderror
    </div>
    <input class="btn form-btn" type="submit" value="SUBMIT">
</form>
@endsection