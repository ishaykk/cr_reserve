@extends('layout')
@section('title', 'Add a new Room')
@section('content')
<div class="row">
    <div class='col-12'>
        <div class="card">
            <div class="card-header"><strong>Add a new Room</strong></div>
            <div class="card-body">
                <ul class="errors text-danger">
                    @foreach($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
                <form action="/rooms" method="post">
                    <div class="form-group">
                        <div class="form-inline">
                            <label for="room_id"><strong>Room Number: </strong></label>
                            <input type="number" id="room_id" name="room_id" class="form-control col-2 ml-2" aria-describedby="roomIdHelpBlock">
                            <small id="roomIdHelpBlock" class="form-text text-muted ml-2"> e.g. 406, first digit is floor number, second and third are room number</small>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-inline">
                            <label for="floor"><strong>Floor: </strong></label>
                            <input type="number" id="floor" name="floor" class="form-control col-2 ml-2">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-inline">
                            <label for="capacity"><strong>Capacity: </strong></label>
                            <input type="number" id="capacity" name="capacity" class="form-control col-2 ml-2">
                        </div>
                    </div> 
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <div class="form-inline">
                                <input type="checkbox" name="projector" class="custom-control-input" id="customSwitch1" aria-describedby="projHelpBlock" checked>
                                <label class="custom-control-label" for="customSwitch1">Projector</label>
                                <small id="projHelpBlock" class="form-text text-muted ml-2">uncheck if there is no projector in this room</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <div class="form-inline">
                                <input type="checkbox" name="available" class="custom-control-input" id="customSwitch2" aria-describedby="aviHelpBlock" checked>
                                <label class="custom-control-label" for="customSwitch2">Available</label>
                                <small id="aviHelpBlock" class="form-text text-muted ml-2">uncheck if room is NOT available for orders</small>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Room</button>     
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$('#room_id').change(function() {
    const leftDigit = (''+$(this).val()[0]);
    //console.log(typeof($(this).val()));
    $('#floor').val(leftDigit);
});
    </script>
@endsection