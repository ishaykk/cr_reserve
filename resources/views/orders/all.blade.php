@extends('layout')
@section('title', 'My Orders')
@section('content')
<div class="row m-5">
    <div class='col-12'>
    @if(session()->get('success'))
        <div class="alert alert-success">{{ session()->get('success') }}</div>
    @endif
        <div class="card">
            <!-- <div class="card-header"><strong>Your orders</strong></div> -->
            <div class="card-header d-flex align-items-center">
                    <span class="float-left"><h5><strong>All orders</strong></h5></span>
                    <span class="float-left ml-2"><a class="btn btn-sm btn-primary" href="{{ url('/orders/search') }}">Create new order</a></span>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr class="text-center"> 
                        <th>Date</th>
                        <th>Start time</th>
                        <th>End time</th>
                        <th>Room id</th>
                        <th>Floor</th>
                        <th>Capacity</th>
                        <th>Projector?</th>
                        <th>Status</th>
                        <th>Created by</th>
                        <th>Created at</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr class="text-center">
                                <td>{{ $order->date->format('d/m/Y') }}</td>
                                <td>{{ $order->start_time->format('H:i') }}</td>
                                <td>{{ $order->end_time->format('H:i') }}</td>
                                <td>{{ $order->room_id }}</td>
                                <td>{{ $order->room->floor }}</td>
                                <td>{{ $order->room->capacity }}</td>
                                <td>{{ ($order->room->projector == 1) ? 'Yes' : 'No' }}</td>
                                <td> {{ ($order->status == 1) ? 'Active' : (($order->status == 2) ? 'Canceled' : 'Completed') }}</td>
                                <td><a href="{{ route('users.show', ['user' => $order->user->id]) }}">{{ $order->user->name }}</a></td>
                                <td>{{ $order->created_at }}</td>
                                <td>
                                    <!-- <div class="float-left">
                                        <a class="btn btn-small btn-info" href="{{ route('orders.edit', $order->order_id) }}">Edit</a>
                                    </div> -->
                                    <div>
                                        <form action="{{ route('orders.destroy', $order->order_id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Cancel</button>
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