@extends('layout')
@section('title', 'Edit User: {{ $user->name }}')
@section('content')
<div class="row">
    <div class='col-12'>
        <div class="card">
            <div class="card-header"><strong>Edit User: {{ $user->name }}</strong></div>
            <div class="card-body">
                <ul class="errors text-danger">
                    @foreach($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
                <form class="form-horizontal" action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                        <div class="form-group form-inline row">
                            <label class="col-sm-2 justify-content-start" for="userid"><strong>User id</strong></label>
                            <input type="number" id="userid" name="userid" value="{{ $user->id }}" readonly> 
                        </div>

                        <div class="form-group form-inline row">
                            <label class="col-sm-2 justify-content-start" for="username"><strong>Username</strong></label>
                            <input type="text" id="username" name="username" value="{{ $user->name }}"> 
                        </div>
                    
                    
                    <div class="form-group form-inline row">
                            <label class="col-sm-2 justify-content-start" for="email"><strong>Email</strong></label>
                            <input type="email" id="email" name="email" value="{{ $user->email }}">
                    </div>
                    <div class="form-group form-inline mt-2">
                        <button type="submit" class="btn btn-primary btn-sm col-sm-2">Save Changes</button>     
                        <button type="submit" class="btn btn-primary btn-sm ml-1 col-sm-3">Sent password reset to email</button>     
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection