@extends('layout')
@section('title', 'Edit Room')
@section('content')
<div class="row">
    <div class='col-12'>
        <div class="card">
            <div class="card-header"><strong>Edit Room {{ $room->room_id }}</strong></div>
            <div class="card-body">
                <ul class="errors text-danger">
                    @foreach($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
                <form action="{{ route('rooms.update', $room->room_id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <div class="form-inline">
                            <label for="room_id"><strong>Room Number: </strong></label>
                            <input type="number" id="room_id" name="room_id" class="form-control col-1 ml-2" aria-describedby="roomIdHelpBlock" value="{{$room->room_id}}"> 
                            <small id="roomIdHelpBlock" class="form-text text-muted ml-2"> e.g. 406, first digit is floor number, second and third are room number</small>
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="floor"><strong>Floor: </strong></label>
                        <input type="number" id="floor" name="floor" class="form-control col-2 ml-2" value="{{ $room->floor }}">
                    </div>

                    <div class="form-group">
                        <label for="capacity"><strong>Capacity: </strong></label>
                        <input type="number" id="capacity" name="capacity" class="form-control col-2 ml-2" value="{{ $room->capacity }}" >
                    </div> 

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="projector" class="custom-control-input" id="customSwitch1" {{($room->projector == 1)? 'checked':''}}>
                            <label class="custom-control-label" for="customSwitch1">Projector</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="available" class="custom-control-input" id="customSwitch2" {{($room->available == 1)? 'checked':''}}>
                            <label class="custom-control-label" for="customSwitch2">Available</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-2">Save Changes</button>     
                    
                </form>
            </div>
        </div>
    </div>
</div>
@endsection