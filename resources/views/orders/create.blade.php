@extends('layout')
@section('title', 'Book a room')
@section('content')
<div class="row m-5">
  <div class='col-12 mt-3'>
    @if(session()->get('success'))
    <div class="alert alert-success">{{ session()->get('success') }}</div>
    @endif
    <div class="card">
      <div class="card-header"><strong>Available rooms at {{ $dataArray['date_il'] }} between {{ $dataArray['sTime'] }} - {{ $dataArray['eTime'] }}    </strong></div>
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
                <td>{{ $room->projector ? 'Yes' : 'No' }}</td>
                <td>{{ $room->occupied ? 'Yes' : 'No' }}</td>
                <td>{{ $room->available ? 'Yes' : 'No' }}</td>
                <td>
                  <form action="/orders" method="post">
                  <input type="hidden" name="start_time" value="{{ $dataArray['sTime'] }}">
                  <input type="hidden" name="end_time" value="{{ $dataArray['eTime'] }}">
                  <input type="hidden" name="date" value="{{ $dataArray['date'] }}">
                  <input type="hidden" name="room_id" value="{{ $room->room_id }}">
                    @csrf
                    <button class="btn btn-small btn-primary " type="submit">Order</button>
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