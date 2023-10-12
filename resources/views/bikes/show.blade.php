@extends('layout')
<style>
    button {
        margin-left: 32px;
        margin-top: 10px;
        font-size: 25px;
        background: none!important;
        border: none;
        padding: 0!important;
        /*optional*/
        font-family: arial, sans-serif;
        /*input has OS specific font-family*/
        color: black;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        color: #a36464;
    }
</style>
<div id="mySidenav" class="sidenav">
    <a href="/"><img src="\images\RGB-LOGO-BYRON-BAY-BIKES.png" alt="Logo" width="150px"></a>
    <a href="/bikes/add">Add Bike</a>
    <a href="/bikes/{{$bike['id']}}/edit">Edit Bike</a>
    <form method="POST" action="/bikes/{{$bike->id}}">
        @csrf
        @method('DELETE')
        <button>Delete Bike</button>
    </form>
  </div>

@section('content')

<h2> {{$bike['ID']}}</h2>
<p>Description: {{$bike['name']}}</p>
<p>Rack: {{$bike['rack']}}</p>
<p>Code: {{$bike['code']}}</p>


@endsection