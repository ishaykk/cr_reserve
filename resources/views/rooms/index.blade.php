@extends('layout')

@section('content')
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
                <th scope="col">Occupied</th>
                <th scope="col">Available</th>
              </tr>
            </thead>
            <tbody>
              @foreach($rooms as $room)
                <tr>
                  <th scope="row">{{ $room->room_id}}</th>
                  <td>{{ $room->floor }}</td>
                  <td>{{ $room->occupied }}</td>
                  <td>{{ $room->available }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
          </div>
        </div>
      </div>
  </div>
  @endsection