@extends('layout')
@section('title', 'Rooms')
@section('content')
<div class='col-12 mt-3'>
  @if(session()->get('success'))
  <div class="alert alert-success">{{ session()->get('success') }}</div>
@endif
<div class="row">
  <div class='col-12 mt-3'>
      <div class="card">
        <div class="card-header"><strong>Room List</strong></div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Room id</th>
                <th scope="col">Floor</th>
                <th scope="col">Capacity</th>
                <th scope="col">Projector</th>
                <th scope="col">Occupied</th>
                <th scope="col">Available</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              @foreach($rooms as $room)
                <tr>
                  <th scope="row">{{ $room->room_id}}</th>
                  <td>{{ $room->floor }}</td>
                  <td>{{ $room->capacity }}</td>
                  <td>{{ $room->projector }}</td>
                  <td>{{ $room->occupied }}</td>
                  <td>{{ $room->available }}</td>
                  <td>
                    <a class="btn btn-small btn-info" href="{{ route('rooms.edit', $room->room_id) }}">Edit</a>
                    <form action="{{ route('rooms.destroy', $room->room_id) }}" method="post">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-small btn-danger" type="submit">Delete</button>
                    </form>
                </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          </div>
        </div>
      </div>
  </div>
  @endsection