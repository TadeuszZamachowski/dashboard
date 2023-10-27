@extends('layout')

@section('content')

<table id="dashboard-orders" class="row-border dashboard" style="margin-bottom:20px">
    <thead>
    <tr>
        <th>Name</th>
        <th>Bike</th>
        <th>Code</th>
        <th>Rack</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Duration</th>
    </tr>
    </thead>

@foreach ($history as $entry)
<tbody>
    <tr>
        {{-- optional($bike->dashboardOrder)->first_name --}}
        <td>{{($entry->dashboardOrder)->first_name}}</td>
        <td>{{($entry->bike)->color}} {{($entry->bike)->type}}</td>
        <td>{{($entry->bike)->code}}</td>
        <td>{{($entry->bike)->rack}}</td>
        <?php $t = strtotime($entry->start_date);   ?>
        <td>{{date('d-m-Y',$t)}}</td>
        <?php $t = strtotime($entry->end_date);   ?>
        <td>{{date('d-m-Y',$t)}}</td>
        @php
            $date1 = new DateTime($entry->start_date);
            $date2 = new DateTime($entry->end_date);
            $interval = $date1->diff($date2);
            $result = $interval->days;
        @endphp
        <td>{{$result}} days</td>
    </tr>
</tbody>
@endforeach
</table>
@endsection