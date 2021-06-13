@extends('layout')
@section('title', 'Add a new Floor')
@section('content')
<div class="row m-1 m-md-5 d-flex justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"><strong>Add a new Floor</strong></div>
            <div class="card-body">
                <ul class="errors text-danger">
                    @foreach($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
                <form action="/floors" method="post">
                    <div class="form-group">
                        <div class="form-inline">
                            <label for="floor_id"><strong>Floor Number: </strong></label>
                            <input type="number" id="floor_id" name="floor_id" class="form-control col-2 ml-2">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Floor</button>     
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
@endsection