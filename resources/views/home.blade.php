@extends('layout')
@section('title', 'Room Reservations Home')
@section('content')
<div class="row m-2 m-md-4 d-flex justify-content-center">
    <div class="col-md-12">
    <h3>Welcome {{ Auth::user()->name }}!</h3>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    @if ($todayOrders->isNotEmpty())
    <div class="card table-responsive">
        <div class="today card-header" data-toggle="collapse" data-target="#today-card-block"><strong class="text-primary">Today's meetings</strong>
            <div class="float-right">
                <i id="collapseIcon" class="fas fa-angle-down"></i>
            </div>
        </div>
        <div id="today-card-block" class="collapse">
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($todayOrders as $order)
                <tr class="text-center">
                    <td>{{ $order->date->format('d/m/Y') }}</td>
                    <td>{{ $order->start_time->format('H:i') }}</td>
                    <td>{{ $order->end_time->format('H:i') }}</td>
                    <th>{{ $order->room_id }}</th>
                    <td>{{ $order->room->floor }}</td>
                    <td>{{ $order->room->capacity }}</td>
                    <td>{{ ($order->room->projector == 1) ? 'Yes' : 'No' }}</td>
                    <td> {{ ($order->status == 1) ? 'Active' : (($order->status == 2) ? 'Canceled' : 'Completed') }}</td>
                    <td>
                        <form action="{{ route('orders.destroy', $order->order_id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-small btn-danger" type="submit">Cancel</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>  
        </div>
    </div>
    @else
        <h6 class="mt-3">You've no meetings today!</h6>
    @endif
    @if($next7DaysOrders->isNotEmpty())
    <div class="card mt-4 table-responsive">
        <div class="card-header" data-toggle="collapse" data-target="#next7-card-block"><strong class="text-primary">Next 7 days meetings</strong>
            <div class="float-right">
                <i id="collapseIcon" class="fas fa-angle-down"></i>
            </div>
        </div>
        <div id="next7-card-block" class="collapse">
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($next7DaysOrders as $order)
                <tr class="text-center">
                    <td>{{ $order->date->format('d/m/Y') }}</td>
                    <td>{{ $order->start_time->format('H:i') }}</td>
                    <td>{{ $order->end_time->format('H:i') }}</td>
                    <th>{{ $order->room_id }}</th>
                    <td>{{ $order->room->floor }}</td>
                    <td>{{ $order->room->capacity }}</td>
                    <td>{{ ($order->room->projector == 1) ? 'Yes' : 'No' }}</td>
                    <td> {{ ($order->status == 1) ? 'Active' : (($order->status == 2) ? 'Canceled' : 'Completed') }}</td>
                    <td>
                        <form action="{{ route('orders.destroy', $order->order_id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-small btn-danger" type="submit">Cancel</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>  
        </div>
    </div>
@endif
</div>
@endsection

@section('javascripts')
<script>
    //$('#card-block').on('shown.bs.collapse', () => {
    $('.collapse').on('shown.bs.collapse', function () {
        $(this).siblings('.card-header').find('#collapseIcon').addClass('fa-angle-up').removeClass('fa-angle-down');
    });
    $('.collapse').on('hidden.bs.collapse', function () {
        $(this).siblings('.card-header').find('#collapseIcon').addClass('fa-angle-down').removeClass('fa-angle-up');
    });
    
</script>
@endsection