@extends('layout')
@section('content')
<h1>Overall</h1>
<table>
    <thead>
        <th>Type</th>
        <th>Amount</th>
    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp
        @foreach ($overallBikes as $bikeType)
            <tr>
                <td>{{$bikeType[0]->color}} {{$bikeType[0]->type}}</td>
                <td>{{count($bikeType)}}</td>

                @php
                    $total += count($bikeType);
                @endphp
            </tr>
        @endforeach
        <tr style="font-weight: bold">
            <td>Total</td>
            <td>{{$total}}</td>
        </tr>
    </tbody>
</table>

@foreach ($locations as $location)
    @php
        $bikeCount = App\Models\Bike::where('location', 'LIKE', $location->value)
                    ->where('status', 'NOT LIKE', 'archive')
                    ->where('status', 'NOT LIKE', 'sell')
                    ->count();
        $locationEmpty = true;
        if($bikeCount > 0) {
            $locationEmpty = false;
        }
    @endphp
    @if (!$locationEmpty)
        <h1>{{$location->value}}</h1>
        <table id="bike-figures-table" class="bike-figures-table clean-table" style="margin-bottom: 20px">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $types = array();
                    $bikeTypes = ['Cruiser', 'Urban', 'Kid'];
                    foreach($bikeTypes as $type) {
                        foreach($colors as $color) {
                            $bikeFigures = App\Models\Bike::where('type', 'LIKE', $type)
                            ->where('color','LIKE',$color['value'])
                            ->where('location', 'LIKE', $location->value)
                            ->where('status', 'NOT LIKE', 'archive')
                            ->where('status', 'NOT LIKE', 'sell')
                            ->get();
                            if(count($bikeFigures) > 0) {
                                $types[] = $bikeFigures;
                            }
                        }
                    }
                    
                    $total = 0;
                @endphp
                @foreach ($types as $bikeType)
                    <tr>
                        <td>{{$bikeType[0]->color}} {{$bikeType[0]->type}}</td>
                        <td>{{count($bikeType)}}</td>

                        @php
                            $total += count($bikeType);
                        @endphp
                    </tr>
                @endforeach
                <tr style="font-weight: bold">
                    <td>Total</td>
                    <td>{{$total}}</td>
                </tr>
            </tbody>
        </table>
    @endif
@endforeach

<h1>Sold</h1>
<table  id="bike-figures-table" class="bike-figures-table clean-table" style="margin-bottom: 20px">
    <thead>
        <th>Type</th>
        <th>Amount</th>
    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp
        @foreach ($soldBikes as $bikeType)
            <tr>
                <td>{{$bikeType[0]->color}} {{$bikeType[0]->type}}</td>
                <td>{{count($bikeType)}}</td>

                @php
                    $total += count($bikeType);
                @endphp
            </tr>
        @endforeach
        <tr style="font-weight: bold">
            <td>Total</td>
            <td>{{$total}}</td>
        </tr>
    </tbody>
</table>
    
@endsection