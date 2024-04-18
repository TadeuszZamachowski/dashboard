@extends('layout')
@section('content')
<!-- Settings are stored in wp_dashboad_automation table. ID 1 is automation settings, ID 2 is sms setting -->
<div class="order-create">
    <div class="left-side">
        @if ($enabledAuto)
            <h1 style="color: green">AUTOMATION IS ENABLED</h1>
            <form method="POST" action="/settings/automation">
                @csrf
                <input type="hidden" id="auto_enabled" name="auto_enabled" value=0>
                <input class="btn" type="submit" value="Disable Automation" style="height: 50px; width: 350px;">
            </form>
        @else
            <h1 style="color: red">AUTOMATION IS DISABLED</h1>
            <form method="POST" action="/settings/automation">
                @csrf
                <input type="hidden" id="auto_enabled" name="auto_enabled" value=1>
                <input class="btn" type="submit" value="Enable Automation" style="height: 50px; width: 350px;">
            </form>
        @endif
    </div>
    <div class="right-side">
        @if ($enabledSms)
            <h1 style="color: green">SMS SENDING IS ENABLED</h1>
            <p style="color: red">Turning off sms sending will also disable automation</p>
            <form method="POST" action="/settings/automationSms">
                @csrf
                <input type="hidden" id="auto_enabled" name="auto_enabled" value=0>
                <input class="btn" type="submit" value="Disable Sms" style="height: 50px; width: 250px;">
            </form>
        @else
            <h1 style="color: red">SMS SENDING IS DISABLED</h1>
            <form method="POST" action="/settings/automationSms">
                @csrf
                <input type="hidden" id="auto_enabled" name="auto_enabled" value=1>
                <input class="btn" type="submit" value="Enable Sms" style="height: 50px; width: 250px;">
            </form>
        @endif
    </div>
</div>
@endsection