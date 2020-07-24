@extends('layout')
@section('title', 'My Orders')
@section('content')
<div class='col-12 mt-3'>
  @if(session()->get('success'))
  <div class="alert alert-success">{{ session()->get('success') }}</div>
@endif
<div class="row">
    <div class='col-12 mt-3'>
        <div class="card">
            <div class="card-header"><strong>Your orders</strong></div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Room id</th>
                        <th>Floor</th>
                        <th>Capacity</th>
                        <th>Projector</th>
                        <th>Date</th>
                        <th>Start time</th>
                        <th>End time</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <th>{{ $order->room_id }}</th>
                                <td>{{ $order->room->floor }}</td>
                                <td>{{ $order->room->capacity }}</td>
                                <td>{{ $order->room->projector }}</td>
                                <td>{{ $order->date->format('d/m/Y') }}</td>
                                <td>{{ $order->start_time->format('H:i') }}</td>
                                <td>{{ $order->end_time->format('H:i') }}</td>
                                <td> {{ ($order->status == 1) ? 'Active' : (($order->status == 2) ? 'Canceled' : 'Completed') }}</td>
                                <td>
                                    <div class="float-left">
                                        <a class="btn btn-small btn-info" href="{{ route('orders.edit', $order->order_id) }}">Edit</a>
                                    </div>
                                    <div class="float-right">
                                        <form action="{{ route('rooms.destroy', $order->order_id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-small btn-danger" type="submit">Delete</button>
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