@extends('layout')

@section('content')


<div class="show-order">
    <div class="left-side">
        <h2> {{$bike['color']}} {{$bike['type']}}</h2>
        <p>Gear: {{$bike['gear']}}</p>
        <p>Accessory: {{$bike['accessory']}}</p>
        <p>Code: {{$bike['code']}}</p>
        <p>Rack: {{$bike['rack']}}</p>
        <p>Location: {{$bike['location']}}</p>
        <p>State: {{$bike['state']}}</p>
        <p>Status: {{$bike['status']}}</p>
        <p>Helmet: {{$bike['helmet']}}</p>
        <p>Notes: {{$bike['notes']}}</p>
    </div>
    <div class="right-side">
        <h2>Order History</h2>
        <h4>Number of rentals: {{count($history)}}</h4>
        @foreach ($history as $entry)
            @php
                $date1 = new DateTime($entry->start_date);
                $date2 = new DateTime($entry->end_date);
                $interval = $date1->diff($date2);
                $duration = $interval->days;
                $order = App\Models\DashboardOrder::where('dashboard_order_id', $entry->order_id)->first();
                if($order->order_status == 'Archived') {
                    $link = "/orders/archive/".$entry->order_id;
                } else {
                    $link = "/orders/".$entry->order_id;
                }
            @endphp
            <p>Order: <a href={{$link}}>{{$entry->order_id}}</a> {{$order->first_name}}</p>
            <p>Start Date: {{date('d-m-Y',strtotime($entry->start_date))}}</p>
            <p>End Date: {{date('d-m-Y',strtotime($entry->end_date))}}</p>
            <p>Duration: {{$duration}} days</p>
            <br>
        @endforeach
    </div>
</div>



@endsection