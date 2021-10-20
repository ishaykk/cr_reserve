@extends('layout')
@section('title', 'Floor listing')
@section('content')
<div class="row m-1 m-md-5 d-flex justify-content-center">
    <div class="col-md-10">
    @if(session()->get('success'))
        <div class="alert alert-success">{{ session()->get('success') }}</div>
    @endif
    @if(session()->get('fail'))
        <div class="alert alert-danger">{{ session()->get('fail') }}</div>
    @endif
        <div class="card">
            <div class="card-header d-flex align-items-center">
                    <span class="float-left"><h5><strong>Floor listing</strong></h5></span>
                    <span class="float-left ml-2"><a class="btn btn-sm btn-primary" href="{{ route('floors.create') }}">Add a floor</a></span>
            </div>
            <div class="card-body">
                <table class="table text-center">
                    <thead>
                        <tr class=""> 
                            <th>id</th>
                            <th>Floor id</th>
                            <th>Floor Drawing</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($floors as $floor)
                        <tr class="">
                            <td>{{ $floor->id }}</td>
                            <td>{{ $floor->floor_id }}</td>
                            <td>
                                @if($floor->drawing)
                                    <a class="btn btn-sm btn-success" href="{{ route('floordrawings.show', $floor->drawing->id) }}">Show Linked Drawing</a>
                                @endif
                                @if($drawings->isEmpty())
                                    <span>No Drawings</span>
                                @else
                                    <a class="btn btn-sm btn-info" href="{{ route('floors.edit', $floor->id) }}">Link Drawing</a>
                                @endif
                            </td>
                            <td>
                                <!-- <div class="float-left">
                                    <a class="btn btn-small btn-info" href="{{ route('floors.edit', $floor->id) }}">Edit</a>
                                </div> -->
                                <div class="btn-group">
                                    <!-- <a class="btn btn-sm btn-info" href="{{ route('floors.edit', $floor->id) }}">Edit</a>                                     -->
                                    <form action="{{ route('floors.destroy', $floor->id) }}" method="post">
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
