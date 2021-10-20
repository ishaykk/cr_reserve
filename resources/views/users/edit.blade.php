@extends('layout')
@section('title', 'Edit User '. $user->name)
@section('content')
<div class="row m-5">
    <div class='col-12'>
        <div class="card">
            <div class="card-header"><strong>Edit User {{ $user->name }}</strong></div>
            <div class="card-body">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <span class="text-danger">{{ $errors->getBag('default')->first('name') }}</span>
                    <div class="form-group">
                        <div class="form-inline">
                            <label for="name"><strong>User name: </strong></label>
                            <input type="text" id="name" name="name" class="form-control col-3 ml-2" value="{{ $user->name }}"> 
                        </div> 
                    </div>     
                    <span class="text-danger">{{ $errors->getBag('default')->first('email') }}</span>
                    <div class="form-group">
                        <div class="form-inline">
                            <label for="email"><strong>Email: </strong></label>
                            <input type="email" id="email" name="email" class="form-control col-3 ml-5" value="{{ $user->email }}">
                        </div> 
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Save Changes</button>     
                </form>
            </div>
        </div>
    </div>
</div>
@endsection