@extends('layout')
@section('title', 'Edit User '. $user->name)
@section('content')
<div class="row m-5">
    <div class='col-12'>
        <div class="card">
            <div class="card-header"><strong>Edit User {{ $user->name }}</strong></div>
            <div class="card-body">
                <ul class="errors text-danger">
                    @foreach($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <div class="form-inline">
                            <label for="name"><strong>User name: </strong></label>
                            <input type="text" id="name" name="name" class="form-control col-3 ml-2" value="{{ $user->name }}"> 
                        </div> 
                    </div>     
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