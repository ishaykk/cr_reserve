@extends('layout')
@section('title', 'Book a room')
@section('content')
<div class="row">
    <div class='col-12'>
        <div class="card">
            <div class="card-header"><strong>Book a room</strong></div>
            <div class="card-body">
                <table>    
                    <tr>
                        <th>Room id</th>
                        <th>Floor</th>
                    </tr>
                @foreach ($rooms as $room)
                    <tr>
                        <td>{{ $room->room_id }}</td>
                        <td>{{ $room->floor }}</td>
                    </tr>
                @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection