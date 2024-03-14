@extends('layout')
@section('content')
    {!! $chart1->renderHtml() !!}

    {!! $chart1->renderChartJsLibrary() !!}
    {!! $chart1->renderJs() !!}

    {!! $chart2->renderHtml() !!}

    {!! $chart2->renderChartJsLibrary() !!}
    {!! $chart2->renderJs() !!}
    
    
@endsection