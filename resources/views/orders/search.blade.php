@extends('layout')
@section('title', 'Search available rooms')
@section('content')
<div class="row m-1 m-md-5 d-flex justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header"><strong>Search for Available Rooms</strong></div>
            <div class="card-body table-responsive">
                <form class="col-md-6" action="/orders/create" method="post" id="form">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                        <input type="checkbox" name="proj" class="custom-control-input" id="customSwitch1">
                        <label class="custom-control-label" for="customSwitch1">Has Projector?</label>
                        </div>
                    </div>
                    
                    <span class="text-danger">{{ $errors->getBag('default')->first('capacity') }}</span>
                    <div class="form-group">
                        <label for="capacity"><strong>Minimum capacity: </strong></label>
                        <select class="ml-2" name="capacity" id="capacity">
                            @foreach ($cap as $c)
                                <option value="{{ $c }}">{{ $c }}</option>
                            @endforeach
                        </select>
                    </div> 

                    <span class="text-danger">{{ $errors->getBag('default')->first('date') }}</span>
                    <div class="form-group">
                        <label for="date"><strong>Date:</strong></label>
                        <input type="date" name="date" id="order-date" value={{ $date }}>
                    </div>
                    
                    <span class="text-danger">{{ $errors->getBag('default')->first('start_time') }}</span>
                    <div class="form-group">
                        <div class="form-inline">
                            <label for="start_time"><strong>Start Time:</strong></label>
                            <input type="text" class="timepicker ml-md-3" name="start_time" id="start_time" placeholder="Start Time" autocomplete="off" style="width:10rem;">
                            <small id="sTimeHelpBlock" class="form-text text-muted ml-md-2"> 15min steps</small>
                        </div>
                    </div>
                    
                    <span class="text-danger">{{ $errors->getBag('default')->first('end_time') }}</span>
                    <div class="form-group">
                        <div class="form-inline">
                            <label for="end_time" class=""><strong>End Time:</strong></label>
                            <input type="text" class="timepicker ml-md-4" name="end_time" id="end_time" placeholder="End Time" autocomplete="off" style="width:10rem;">
                            <small id="eTimeHelpBlock" class="form-text text-muted ml-md-2"> 15min steps</small>
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <input id="setTimeExample" type="text" class="time" />
                        <button id="setTimeButton">Set current time</button>                    
                    </div> -->

                    <button type="submit" class="btn btn-primary mt-2">Show available rooms</button>    
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$(function() {
    //$('#form').reset();
    const constants = {!! $config !!};
    $('input[type=checkbox]').checked = false;
    $('#start_time').timepicker({
    timeFormat: 'H:mm',
    interval: constants.orders.orders_time_interval,
    minTime: constants.orders.min_start_time,
    maxTime: constants.orders.max_start_time,
    dynamic: true,
    dropdown: true,
    scrollbar: true
    });
    //console.log(element);
    $('#end_time').timepicker({
    timeFormat: 'H:mm',
    interval: constants.orders.orders_time_interval,
    minTime: constants.orders.min_end_time,
    maxTime: constants.orders.max_end_time,
    dynamic: true,
    dropdown: true,
    scrollbar: true
    });
});
// $('#start_time').on('change'(function() {
//     console.log($(this).val());
// });
    //console.log($('#start_time').timepicker().getTime());
</script>
@endsection

@section('javascripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
@endsection
