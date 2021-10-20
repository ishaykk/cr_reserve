@extends('layout')
@section('title', 'Edit Room')
@section('content')
<div class="row m-1 m-md-5 justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><strong>Edit Room {{ $room->room_id }}</strong></div>
            <div class="card-body">
                <form action="{{ route('rooms.update', $room->room_id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <span class="text-danger">{{ $errors->getBag('default')->first('room_id') }}</span>
                    <div class="form-group">
                        <div class="form-inline">
                            <label for="room_id"><strong>Room Number: </strong></label>
                            <input type="number" id="room_id" name="room_id" class="form-control col-3 col-md-2 ml-2" aria-describedby="roomIdHelpBlock" value="{{$room->room_id}}"> 
                            <small id="roomIdHelpBlock" class="form-text text-muted ml-2"> e.g. 406, first digit is floor number, second and third are room number</small>
                        </div>
                    </div>
                    
                    
                    <!-- <div class="form-group">
                        <div class="form-inline">
                            <label for="floor"><strong>Floor: </strong></label>
                            <input type="number" id="floor" name="floor" class="form-control col-2 ml-2" value="{{ $room->floor }}">
                        </div>
                    </div> -->
                    <span class="text-danger">{{ $errors->getBag('default')->first('floor') }}</span>
                    <div class="form-group">
                        <div class="form-inline">
                            <label for="floor"><strong>Floor: </strong></label>
                            <select class="form-select ml-2" id="floor" name="floor" aria-label="Default select example">
                                <option value="">Select Floor</option>    
                            @foreach($floors as $floor)
                                <option value="{{ $floor->floor_id }}" {{ $room->floor == $floor->floor_id ? 'selected' : ''}}>{{ $floor->floor_id }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <span class="text-danger">{{ $errors->getBag('default')->first('capacity') }}</span>
                    <div class="form-group">
                        <div class="form-inline">
                            <label for="capacity"><strong>Capacity: </strong></label>
                            <input type="number" id="capacity" name="capacity" class="form-control col-2 ml-2" value="{{ $room->capacity }}">
                        </div>
                    </div> 

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="projector" class="custom-control-input" id="proj" {{ $room->projector == 1 ? 'checked':''}}>
                            <label class="custom-control-label" for="proj">Projector</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="available" class="custom-control-input" id="avi" {{$room->available == 1 ? 'checked':''}}>
                            <label class="custom-control-label" for="avi">Available</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-2">Save Changes</button>     
                    
                </form>
            </div>
        </div>
    </div>
</div>
@endsection