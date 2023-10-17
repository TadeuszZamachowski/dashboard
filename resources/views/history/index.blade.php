@extends('layout')

@section('content')

<table id="dashboard-orders" class="row-border dashboard" style="margin-bottom:20px">
    <thead>
    <tr>
        <th>ID</th>
        <th>Bike ID</th>
        <th>Order ID</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Duration</th>
    </tr>
    </thead>

@foreach ($history as $entry)
<tbody>
    <tr>
        {{-- <td><input type="checkbox" name="order_id" value={{$bike['id']}}></td> --}}
        <td>{{$entry->id}}</td>
        <td>{{$entry->bike_id}}</td>
        <td>{{$entry->order_id}}</td>
        <td>{{$entry->start_date}}</td>
        <td>{{$entry->end_date}}</td>
        @php
            $date1 = new DateTime($entry->start_date);
            $date2 = new DateTime($entry->end_date);
            $interval = $date1->diff($date2);
            $result = $interval->days;
        @endphp
        <td>{{$result}} days</td>
        {{-- add duration --}}
    </tr>
</tbody>
@endforeach
@endsection