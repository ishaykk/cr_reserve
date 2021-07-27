@extends('layout')
@section('title', 'Add a new Room')
@section('content')
<div class="row m-1 m-md-5 d-flex justify-content-center">
    <div class='col-md-10'>
        <div class="card">
            <div class="card-header"><strong>Add a new Room</strong></div>
            <div class="card-body">
                <form action="/rooms" method="post">

                    <span class="text-danger">{{ $errors->getBag('default')->first('room_id') }}</span>
                    <div class="form-group">
                        <div class="form-inline">
                            <label for="room_id"><strong>Room Number: </strong></label>
                            <input type="number" id="room_id" name="room_id" value="{{ old('room_id') }}" class="form-control col-2 ml-2" aria-describedby="roomIdHelpBlock">
                            <small id="roomIdHelpBlock" class="form-text text-muted ml-2"> e.g. 406, first digit is floor number, second and third are room number</small>
                        </div>
                    </div>
                    
                    <span class="text-danger">{{ $errors->getBag('default')->first('floor') }}</span>
                    <div class="form-group">
                        <div class="form-inline">
                            <label for="floor"><strong>Floor: </strong></label>
                            <select class="form-select ml-2" id="floor" name="floor" aria-label="Default select example">
                                <option value="">Select Floor</option>    
                            @foreach($floors as $floor)
                                    <option value="{{ $floor->floor_id }}" {{ old('floor') == $floor->floor_id ? 'selected' : '' }}>{{ $floor->floor_id }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <span class="text-danger">{{ $errors->getBag('default')->first('capacity') }}</span>
                    <div class="form-group">
                        <div class="form-inline">
                            <label for="capacity"><strong>Capacity: </strong></label>
                            <input type="number" id="capacity" name="capacity" value="{{ old('capacity') }}" class="form-control col-2 ml-2">
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
@endsection
