@extends('layout')
@section('title', 'My Drawings')
@section('styles')
    <link href="{{ asset('css/floordrawing.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="row m-5">
    <div class='col-12'>
    @if(session()->get('success'))
        <div class="alert alert-success">{{ session()->get('success') }}</div>
    @endif
        <div class="card">
            <div class="card-header"><strong>Your Drawings</strong></div>
            <div class="card-body">
            <table class="table">
                    <thead>
                    <tr class="text-center"> 
                        <th>Drawing id</th>
                        <th>Builing</th>
                        <th>Floor</th>
                        <th>Description</th>
                        <th>Created by</th>
                        <th>Creation date</th>
                        <th>Last edit by</th>
                        <th>Last edit date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($drawings as $draw)
                            <tr class="text-center">
                                <td>{{ $draw->id }}</td>
                                <td>{{ $draw->building }}</td>
                                <td>{{ $draw->floor_id }}</td>
                                <td>{{ $draw->description }}</td>
                                <td>{{ $draw->created_by }}</td>
                                <td>{{ $draw->created_at->format('d/m/Y') }}</td>
                                <td>{{ $draw->last_update_by }}</td>
                                <td>{{ $draw->updated_at->format('d/m/Y') }}</td>
                                <td>
                                    <!-- <div class="float-left">
                                        <a class="btn btn-small btn-info" href="{{ route('floordrawings.edit', $draw->id) }}">Edit</a>
                                    </div> -->
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-info" href="{{ route('floordrawings.show', $draw->id) }}">Show</a>                                    
                                        <form action="{{ route('floordrawings.destroy', $draw->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>      
            </div>
        </div>
    </div>
</div>
@endsection
