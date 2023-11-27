@extends('layout')
@section('content')
    <form method="POST" action="/messages/send">
        @csrf
        <textarea name="sms_input" id="sms_input" cols="30" rows="10"></textarea>
        <button type="submit" class="btn">SUBMIT</button>
    </form>
@endsection