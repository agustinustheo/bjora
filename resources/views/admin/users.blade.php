@extends('layout.manage')
@section('content')
<div class="col-md-10 mx-auto admin-page">
    <a href="{{route('add-user-form')}}" type="button" class="btn btn-danger">Add User</a>
    <h1>Manage User</h1>
    <table class="admin-page-table">
        <tr class="user-page-content">
          <th>#</th>
          <th>Role</th>
          <th>Email</th>
          <th>Fullname</th>
          <th>Gender</th>
          <th>Address</th>
          <th>Profile Picture</th>
          <th>DOB</th>
          <th>Action</th>
        </tr>
    @foreach ($users as $i=>$user)
        <tr class="user-page-content">
            <td>{{$i+1}}</td>
            <td>{{$user->role}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->gender}}</td>
            <td>{{$user->address}}</td>
            <td><img src="{{ URL::asset($user->profile_picture) }}" style="width:100px"></td>
            <td>{{$user->birthday}}</td>
            <td>
                <div class="table-action">
                    <a href="{{route('edit-user-form', ['id' => $user->id])}}" type="button" class="btn btn-warning">Edit</a>
                    <form action="{{route('delete-user', ['id' => $user->id])}}" method="POST">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
    </table>
    <div class="admin-paginate">
        {{$users->links()}}
    </div>
</div>
@endsection