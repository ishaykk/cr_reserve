@extends('layout')
@section('title', 'Add a new Room')
@section('content')
<div class="row">
    <div class='col-12'>
        <div class="card">
            <div class="card-header"><strong>Add a new Room</strong></div>
            <div class="card-body">
                <form action="/rooms" method="POST">
                    <div class="form-group">
                        <div class="form-inline">
                            <label for="room_id"><strong>Room Number: </strong></label>
                            <input type="text" id="room_id" name="room_id" class="form-control col-1 ml-2" aria-describedby="roomIdHelpBlock">
                            <small id="roomIdHelpBlock" class="form-text text-muted ml-2"> e.g. 406, first digit is floor number, second and third are room number</small>
                        </div>
                        <div class="text-danger">{{ $errors->first('room_id') }}</div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="floor"><strong>Floor: </strong></label>
                        <select class="ml-2" name="floor" id="floor">
                            @foreach ($floors as $floor)
                                <option value="{{ $floor }}">{{ $floor }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="capacity"><strong>Capacity: </strong></label>
                        <select class="ml-2" name="capacity" id="capacity">
                            @foreach ($cap as $c)
                                <option value="{{ $c }}">{{ $c }}</option>
                            @endforeach
                        </select>
                    </div> 

                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="projector" class="custom-control-input" id="customSwitch1">
                        <label class="custom-control-label" for="customSwitch1">Projector</label>
                    </div>

                    <button type="submit" class="btn btn-primary mt-2">Add Room</button>     
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
@endsection