@extends('layout')
@section('content')
<table style="margin-bottom:20px">
    <thead>
    <tr>
        <th>Message</th>
        <th>Text</th>
        <th>Edit</th>
    </tr>
    </thead>
@foreach ($messages as $message)
    <tbody>
        <tr>
            <td>{{$message->name}}</td>
            <td>{{$message->value}}</td>
            <td>
                <a href="/messages/edit/{{$message->id}}"><i class="fas fa-edit"></i></a>
            </td>
        </tr>
    </tbody>
@endforeach
</table>
@endsection