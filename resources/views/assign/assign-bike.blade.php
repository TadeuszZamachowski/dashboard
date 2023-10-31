@extends('layout')
@section('content')
<form method="POST" action="/bikes/assign/{{$bike->id}}">
    @csrf
    <h1>Assign</h1>
    <div class="assign">
        <label for="dashboard_order_id">Orders:</label><br>
        <select name="dashboard_order_id" id="dashboard_order_id">
            @foreach ($orders as $order)
                <option value="{{$order->dashboard_order_id}}">{{$order->dashboard_order_id}} | {{$order->first_name}} {{$order->last_name}}</option>
            @endforeach
        </select>
    </div>
    {{-- last_url for redirecting to the appropraite page after edit --}}
    <input type="hidden" name="last_url" value="{{  URL::previous() }}">
    <input class="btn form-btn" type="submit" value="Submit">
    @if($bike->dashboard_order_id != null)
        <form method="POST" action="/bikes/assign/{{$bike->id}}">
            @csrf
            @method('DELETE')
            <input class="btn form-btn" type="submit" value="Cancel assignement">
            <p class="form-btn" style="color: red">This will cancel the bike assignement.</p>
            <p class="form-btn" style="color: red; margin-top:0px;">This assignement will not appear in archive</p>
        </form>
    @endif
</form>
@endsection