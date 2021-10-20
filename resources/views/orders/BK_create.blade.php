@extends('layout')
@section('title', 'Book a room')
@section('content')
<div class="row">
    <div class='col-12'>
        <div class="card">
            <div class="card-header"><strong>Book a room</strong></div>
            <div class="card-body">
                <form class="col-md-6" action="/orders" method="POST">
                    <div class="form-group">
                        <label for="capacity"><strong>Select minimum capacity: </strong></label>
                        <select class="ml-2" name="capacity" id="capacity">
                            @foreach ($cap as $c)
                                <option value="{{ $c }}">{{ $c }}</option>
                            @endforeach
                        </select>
                    </div> 
                    
                    <div class="form-group">
                        <label for="floor"><strong>Select a room: </strong></label>
                        <select class="ml-2" name="room" id="room">
                            @foreach ($rooms as $room)
                                <option value="{{ $room }}">{{ $room }}</option>
                            @endforeach
                        </select>
                    </div>
                            

                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="projector" class="custom-control-input" id="customSwitch1">
                        <label class="custom-control-label" for="customSwitch1">Projector</label>
                    </div>

                    {{-- <div class="form-group">
                        <div class="datepicker date input-group p-0 shadow-sm">
                            <input type="text" placeholder="Date" class="form-control py-4 px-4" id="date">
                            <div class="input-group-append"><span class="input-group-text px-4"><i class="fa fa-clock-o"></i></span></div>
                        </div>
                    </div> --}}

                    {{-- <div class="input-group date">
                        <input type="text" class="form-control" value="">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div> --}}

                    <div class="form-group">
                        <label for="date" class="col-3"><strong>Date:</strong></label>
                        <input type="date" class="" name="date" id="order-date" value={{ $date }}>
                    </div>

                    <div class="form-group">
                        <div class="form-inline">
                            <label for="sTime" class="col-3"><strong>Start Time:</strong></label>
                            <input type="time" class="" name="sTime" id="sTime" value="" step="1800" aria-describedby="sTimeHelpBlock"/>
                            <small id="sTimeHelpBlock" class="form-text text-muted ml-2"> 30min steps</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-inline">
                            <label for="eTime" class="col-3"><strong>End Time:</strong></label>
                            <input type="time" class="" name="eTime" id="eTime" value="" step="1800" aria-describedby="eTimeHelpBlock"/>
                            <small id="eTimeHelpBlock" class="form-text text-muted ml-2">30min steps</small>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-2">Show available rooms</button>     
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascripts')
<script>
    $(document).ready(function(){
        let stime = $('#sTime');
        stime.change(function() {
            const timeParts =  $(this).val().split(":");
            let autoEndTime = new Date()
            autoEndTime.setHours(timeParts[0]);
            autoEndTime.setMinutes(timeParts[1]);
            autoEndTime.setHours(autoEndTime.getHours() + 1);
            const newTime = autoEndTime.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit', hour12: false});
            $('#eTime').val(newTime);
        })
    });
</script>
@endsection