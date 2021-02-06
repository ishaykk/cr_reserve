@extends('layout')
@section('title', 'Rooms')
@section('content')
<div class="row">
  <div class='col-12 mt-3'>
      <div class="card">
        <div class="card-header"><strong>User Details</strong></div>
        <div class="card-body">
            <div><strong>Username:</strong> {{ $user->name }}</div>
            <div><strong>Email:</strong> {{ $user->email }}</div>
            <div><strong>Roles:</strong> {{ implode(', ', $user->roles()->get()->pluck('name')->toArray()) }}</div>
            <div><strong>Registered at:</strong> {{ $user->created_at }}</div>
        </div>
    </div>
</div>
@endsection