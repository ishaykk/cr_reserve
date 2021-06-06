@extends('layout')
@section('title', 'User '. $user->id. ' Details')
@section('content')
<div class="row m-5">
  <div class='col-12'>
        @if(session()->get('success'))
        <div class="alert alert-success">{{ session()->get('success') }}</div>
        @endif
        @if(session()->get('fail'))
        <div class="alert alert-danger">{{ session()->get('fail') }}</div>
        @endif
      <div class="card">
        <div class="card-header d-flex align-items-center">
                    <span class="float-left"><h5><strong>User {{ $user->id }} Details</strong></h5></span>
                    <span class="float-left ml-2"><a class="btn btn-sm btn-primary" href="{{ route('users.edit', ['user' => $user->id]) }}">Edit Profile</a></span>
            </div>
        <div class="card-body">
            <div><strong>Username:</strong> {{ $user->name }}</div>
            <div><strong>Email:</strong> {{ $user->email }}</div>
            <div><strong>Roles:</strong> {{ implode(', ', $user->roles()->get()->pluck('name')->toArray()) }}</div>
            <div><strong>Registered at:</strong> {{ $user->created_at }}</div>
        </div>
    </div>
</div>
@endsection