@extends('layout')
@section('content')
<table id="orders-table" class="bikes-table">
    <thead>
    <tr>
        {{-- sortTable(n, isStatus, isLink, isDate, isNum) --}}
        <th onclick="sortTable(1,0,0,0,0)">Bike ID</th>
        <th onclick="sortTable(2,0,0,0,0)">Work</th>
        <th onclick="sortTable(3,0,0,0,0)">Rust</th>
        <th onclick="sortTable(4,0,0,0,0)">Brakes</th>
        <th onclick="sortTable(5,0,0,0,0)">Wheels</th>
        <th onclick="sortTable(6,0,0,0,0)">Chain</th>
        <th onclick="sortTable(7,0,0,0,0)">Notes</th>
    </tr>
    </thead>
@foreach ($checks as $check)
    
    <tbody>
        <tr>
            <td><a href="/bikes/{{$check->bike_id}}">{{$check->bike_id}}</a></td>
            <td>{{$check->work}}</td>
            <td>{{$check->rust}}</td>
            <td>{{$check->brakes}}</td>
            <td>{{$check->wheels}}</td>
            <td>{{$check->chain}}</td>
            <td>{{$check->notes}}</td>
        </tr>
    </tbody>
@endforeach
</table>
@endsection