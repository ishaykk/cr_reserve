@extends('layout')
@section('title', 'Edit User: {{ $user->name }}')
@section('content')
<div class="row m-1 m-md-5 justify-content-center">
    <div class="col-md-6">
        @if(session()->get('error'))
        <div class="alert alert-danger">{{ session()->get('error') }}</div>
        @endif
        <div class="card">
            <div class="card-header"><strong>Edit User: {{ $user->name }}</strong></div>
            <div class="card-body table-responsive">
                <form class="" action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group"><strong>Role</strong>
                        @foreach($roles as $role)
                        <div class="form-check">
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" @if($user->roles()->get()->contains($role->id))
                            checked="checked" @endif>
                            <label>{{ $role->name }}</label>
                        </div>
                        @endforeach
                    </div>

                    <span class="text-danger">{{ $errors->getBag('default')->first('userid') }}</span>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="userid">User id</span>
                        </div>
                        <input type="number" class="form-control" value="{{ $user->id }}" name="userid" aria-label="userid" aria-describedby="userid" readonly>
                    </div>

                    <span class="text-danger">{{ $errors->getBag('default')->first('name') }}</span>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="username">Username</span>
                        </div>
                        <input type="text" class="form-control" value="{{ $user->name }}" name="name" aria-label="username" aria-describedby="username">
                    </div>

                    <span class="text-danger">{{ $errors->getBag('default')->first('email') }}</span>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="email">Email</span>
                        </div>
                        <input type="email" class="form-control" value="{{ $user->email }}" name="email" aria-label="email" aria-describedby="email">
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary btn-sm">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection