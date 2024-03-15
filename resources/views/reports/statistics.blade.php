@extends('layout')
@section('content')
<div class="chart">
    {!! $chart1->renderHtml() !!}

    {!! $chart1->renderChartJsLibrary() !!}
    {!! $chart1->renderJs() !!}
</div>
<div class="chart">
    {!! $chart2->renderHtml() !!}

    {!! $chart2->renderChartJsLibrary() !!}
    {!! $chart2->renderJs() !!}
</div>
    
    
@endsection