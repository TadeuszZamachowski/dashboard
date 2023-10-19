@extends('layout')

@section('content')

<h2> {{$bike['ID']}}</h2>
<p>Color: {{$bike['color']}}</p>
<p>Rack: {{$bike['rack']}}</p>
<p>Code: {{$bike['code']}}</p>


@endsection