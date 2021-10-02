@extends('layout')
@section('title', 'Edit Configuration')
@section('csrf')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="row m-1 m-md-5 d-flex justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"><strong>Edit Configuration</strong></div>
            <div class="card-body">
                <ul class="errors text-danger">
                    @foreach($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
                <form action="{{ route('config.update') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    @foreach($configs as $config)
                        <h3>{{ ucwords($config[0]->section) }}</h3>
                        @foreach($config as $row)
                            <div class="form-group">
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