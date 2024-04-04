@extends('layout')
@section('content')
    <h1>Edit {{$message->name}} message</h1>
    <form method="POST" action="/messages/edit/{{$message->id}}">
    @csrf
    @method('PUT')
        <label for="value"></label>
        <textarea name="value" id="value" cols="120" rows="10">{{$message->value}}</textarea>  
        <input class="btn form-btn" type="submit" value="Submit">  
    </form>
@endsection