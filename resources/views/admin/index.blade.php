@extends('layout')
@section('title', 'Users list')
@section('content')
<div class='col-12'>
  @if(session()->get('success'))
  <div class="alert alert-success">{{ session()->get('success') }}</div>
@endif
<div class="row">
        <div class="card">
            <div class="card-header"><strong>Users List</strong></div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>email</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->updated_at }}</td>
                                <td>
                                <div class="row">
                                    <div class="">
                                        <a class="btn btn-small btn-info" href="{{ route('admin.users.edit', $user->id) }}">Edit</a>
                                    </div>
                                    <form class="ml-3" action="{{ route('admin.users.destroy', $user->id) }}" method="post">
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