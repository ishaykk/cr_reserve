@extends('layout')
@section('title', 'Edit User: {{ $user->name }}')
@section('content')
<div class="row">
    <div class="col-12">
        @if(session()->get('error'))
            <div class="alert alert-danger">{{ session()->get('error') }}</div>
        @endif
        <ul class="errors text-danger">
                    @foreach($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
        <div class="card">
            <div class="card-header"><strong>Edit User: {{ $user->name }}</strong></div>
            <div class="card-body">
                
                <form class="form-horizontal" action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PATCH')
                        <div class="form-group"><strong>Role</strong>
                            @foreach($roles as $role)
                            <div class="form-check">
                                <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                @if($user->roles()->get()->contains($role->id)) 
                                    checked="checked" @endif>
                                <label>{{ $role->name }}</label>
                            </div>
                            @endforeach
                        </div>
                        <div class="form-group form-inline row">
                            <label class="col-sm-2 justify-content-start" for="userid"><strong>User id</strong></label>
                            <input type="number" id="userid" name="userid" value="{{ $user->id }}" readonly> 
                        </div>

                        <div class="form-group form-inline row">
                            <label class="col-sm-2 justify-content-start" for="name"><strong>Username</strong></label>
                            <input type="text" id="name" name="name" value="{{ $user->name }}"> 
                        </div>
                    
                    
                        <div class="form-group form-inline row">
                                <label class="col-sm-2 justify-content-start" for="email"><strong>Email</strong></label>
                                <input type="email" id="email" name="email" value="{{ $user->email }}">
                        </div>
                    <div>
                        <button type="submit" class="btn btn-primary btn-sm col-sm-2">Update User</button> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection