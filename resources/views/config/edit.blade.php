@extends('layout')
@section('title', 'Edit Configuration')
@section('csrf')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="row m-1 m-md-5 d-flex justify-content-center">
    <div class="col-md-12">
        @if(session()->get('success'))
            <div class="alert alert-success">{{ session()->get('success') }}</div>
        @endif
        <div class="card">
            <div class="card-header"><strong>Edit Configuration</strong></div>
            <div class="card-body">
                <form action="{{ route('config.update') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    @foreach($configs as $config)
                        <h3>{{ ucwords($config[0]->section) }}</h3>
                        @foreach($config as $row)
                            <div class="form-group">
                                <span class="text-danger">{{ $errors->getBag('default')->first($row->key) }}</span>
                                <div class="form-inline">
                                    <label for="{{ $row->key }}"><strong>{{ $row->label }}: </strong></label>
                                    <input type="text" id="{{ $row->key }}" name="{{ $row->key }}" class="form-control col-3 col-md-2 ml-2" value="{{ $row->value }}"> 
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                    <button type="submit" class="btn btn-primary mt-2">Save Changes</button>     
                </form>
            </div>
        </div>
    </div>
</div>
@endsection