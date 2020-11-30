@extends('layout')
@section('title', 'Search available rooms')
@section('content')
<div class="row">
    <div class='col-12'>
        <div class="card">
            <div class="card-header"><strong>Show Available Rooms</strong></div>
            <div class="card-body">
                <form class="col-md-6" action="/orders/create" method="get">
                    <div class="form-group">
                        <label for="capacity"><strong>Select minimum capacity: </strong></label>
                        <select class="ml-2" name="capacity" id="capacity">
                            @foreach ($cap as $c)
                                <option value="{{ $c }}">{{ $c }}</option>
                            @endforeach
                        </select>
                    </div> 

                    <div class="form-group">
                        <label for="date"><strong>Date:</strong></label>
                        <input type="date" class="" name="date" id="order-date" value={{ $date }}>
                    </div>

                    <button type="submit" class="btn btn-primary mt-2">Show available rooms</button>    
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
@endsection