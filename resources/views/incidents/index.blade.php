@extends('layout')

@section('content')

<table id="orders-table" class="orders-table">
    <thead>
    <tr>
        {{-- sortTable(n, isStatus, isLink, isDate, isNum) --}}
        <th onclick="sortTable(0,0,0,1,0)">Date</th>
        <th onclick="sortTable(1,0,0,0,0)">Order ID</th>
        <th onclick="sortTable(2,0,0,0,0)">Bike ID</th>
        <th onclick="sortTable(3,0,0,0,0)">Report</th>
        <th onclick="sortTable(4,0,0,0,0)">Action</th>
        <th></th>
        <th></th>
    </tr>
    </thead>
@php
    $even = false;
@endphp
@foreach ($incidents as $incident)
    <tbody>
    <tr>
        <td>{{$incident->date}}</td>
        <td>{{$incident->dashboard_order_id}}</td>
        <td>{{$incident->bike_id}}</td>
        <td>{{$incident->report}}</td>
        <td>{{$incident->action}}</td>
        <td>
            <a href="/incidents/{{$incident->id}}/edit"><i class="fas fa-edit"></i></a>
        </td>
        <td>
            <form method="POST" action="/incidents/{{$incident->id}}">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa-solid fa-trash" style="color: #000000;"></i></button>
            </form>
        </td>
        
    </tr>
    </tbody>
    @php
        if($even == true) {
            $even = false;
        } else {
            $even = true;
        }
    @endphp
@endforeach
</table>
<div class="pagination">
    {{ $incidents->onEachSide(1)->links() }}
</div>
<a href="/incidents/add" class="btn">Add Incident</a>

@endsection

