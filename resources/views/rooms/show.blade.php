@extends('layout')
@section('title', 'Room '. $room->room_id. ' Details')
@section('content')
<div class="row m-5">
  <div class='col-12'>
        @if(session()->get('success'))
        <div class="alert alert-success">{{ session()->get('success') }}</div>
        @endif
        @if(session()->get('fail'))
        <div class="alert alert-danger">{{ session()->get('fail') }}</div>
        @endif
      <div class="card">
        <div class="card-header d-flex align-items-center">
                    <span class="float-left"><h5><strong>Room {{ $room->room_id }} Details</strong></h5></span>
                    <span class="float-left ml-2"><a class="btn btn-sm btn-primary" href="{{ route('rooms.edit', ['room' => $room->room_id]) }}">Edit</a></span>
            </div>
        <div class="card-body">
            <div><strong>Room id:</strong> {{ $room->room_id }}</div>
            <div><strong>Floor:</strong> {{ $room->floor }}</div>
            <div><strong>Capacity:</strong> {{ $room->capacity }}</div>
            <div><strong>Projector:</strong> {{ ($room->projector) ? 'Yes' : 'No' }}</div>
            <div><strong>Occupied:</strong> {{ ($room->occupied) ? 'Yes' : 'No' }}</div>
            <div><strong>Available:</strong> {{ ($room->available) ? 'Yes' : 'No' }}</div>
            <div><strong>Created at:</strong> {{ $room->created_at }}</div>
        </div>
    </div>
</div>
@endsection