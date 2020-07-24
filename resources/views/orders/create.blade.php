@extends('layout')
@section('title', 'Book a room')
@section('content')
<div class="row">
    <div class='col-12 mt-3'>
        <div class="card">
            <div class="card-header"><strong>Book a room</strong></div>
            <div class="card-body">
                <form action="/orders" method="POST">
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
                        <select class="ml-2" name="floor" id="floor">
                            @foreach ($rooms as $room)
                                <option value="{{ $room }}">{{ $room }}</option>
                            @endforeach
                        </select>
                    </div>
                            

                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="projector" class="custom-control-input" id="customSwitch1">
                        <label class="custom-control-label" for="customSwitch1">Projector</label>
                    </div>

                    <button type="submit" class="btn btn-primary mt-2">Show available rooms</button>     
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#datetimepicker').datetimepicker({
    format: 'yyyy-mm-dd'
});
</script>
@endsection