@extends('layout')
@section('content')

    <h1>{{ $chart1->options['chart_title'] }}</h1>
    {!! $chart1->renderHtml() !!}

    {!! $chart1->renderChartJsLibrary() !!}
    {!! $chart1->renderJs() !!}
@endsection