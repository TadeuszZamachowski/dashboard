@extends('layout')

@section('content')

<h2> {{$bike['ID']}}</h2>
<p>Description: {{$bike['name']}}</p>
<p>Rack: {{$bike['rack']}}</p>
<p>Code: {{$bike['code']}}</p>


@endsection