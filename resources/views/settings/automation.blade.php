@extends('layout')
@section('content')
    @if ($enabled)
        <h1 style="color: green">AUTOMATION IS ENABLED</h1>
        <form method="POST" action="/settings/automation">
            @csrf
            <input type="hidden" id="auto_enabled" name="auto_enabled" value=0>
            <input class="btn" type="submit" value="Disable Automation">
        </form>
    @else
        <h1 style="color: red">AUTOMATION IS DISABLED</h1>
        <form method="POST" action="/settings/automation">
            @csrf
            <input type="hidden" id="auto_enabled" name="auto_enabled" value=1>
            <input class="btn" type="submit" value="Enable Automation">
        </form>
    @endif
@endsection