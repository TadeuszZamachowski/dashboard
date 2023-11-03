@extends('layout')

@section('content')

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



@endsection