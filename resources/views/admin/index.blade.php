@extends('layout')
@section('title', 'Users list')
@section('content')
<div class="row m-1 m-md-5">
<div class='col-md-12'>
    @if(session()->get('success'))
        <div class="alert alert-success">{{ session()->get('success') }}</div>
    @endif  
    @if(session()->get('error'))
            <div class="alert alert-danger">{{ session()->get('error') }}</div>
    @endif
        <div class="card">
            <div class="card-header"><strong>Users List</strong></div>
            <div class="card-body table-responsive">
                <table class="table text-center">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>email</th>
                        <th>Role</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ implode(', ', $user->roles()->get()->pluck('name')->toArray()) }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->updated_at }}</td>
                                <td>
                                <div class="btn-group">
                                    <a class="btn btn-small btn-info" href="{{ route('admin.users.edit', $user->id) }}">Edit</a>
                                    <form class="" action="{{ route('admin.users.destroy', $user->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                            <button class="btn btn-small btn-danger" type="submit">Delete</button>
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
@endsection