@extends('layout')
@section('title', 'Rooms')
@section('content')
<div class="row m-5">
  <div class='col-12'>
    @if(session()->get('success'))
    <div class="alert alert-success">{{ session()->get('success') }}</div>
    @endif
      <div class="card">
        <div class="card-header"><strong>Room List</strong></div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr class="text-center">
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
                <tr class="text-center">
                  <td>{{ $room->room_id}}</td>
                  <td>{{ $room->floor }}</td>
                  <td>{{ $room->capacity }}</td>
                  <td>{{ $room->projector }}</td>
                  <td>{{ $room->occupied }}</td>
                  <td>{{ $room->available }}</td>
                  <td>
                  <div class="btn-group" role="group" aria-label="Basic example">
                    <a class="btn btn-sm btn-info" href="{{ route('rooms.edit', $room->room_id) }}">Edit</a>
                    <form action="{{ route('rooms.destroy', $room->room_id) }}" method="post">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                    </form>
                  </div>
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