@extends('layout')
@section('title', 'My Orders')
@section('content')
<div class="row">
    <div class='col-12'>
    @if(session()->get('success'))
        <div class="alert alert-success">{{ session()->get('success') }}</div>
    @endif
        <div class="card">
            <div class="card-header"><strong>Your Drawings</strong></div>
            <div class="card-body">
            </div>
        </div>
    </div>
</div>
@endsection
