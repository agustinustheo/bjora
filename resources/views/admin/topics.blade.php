@extends('layout.manage')
@section('content')
<div class="col-md-10 mx-auto admin-page">
    <a href="{{route('add-topic-form')}}" type="button" class="btn btn-danger">Add Topic</a>
    <h1>Manage Topic</h1>
    <table class="admin-page-table">
        <tr class="topic-page-content">
          <th>#</th>
          <th>Name</th>
          <th>Action</th>
        </tr>
    @foreach ($topics as $i=>$topic)
        <tr class="topic-page-content">
            <td>{{$i+1}}</td>
            <td class="topic-name">{{$topic->name}}</td>
            <td>
                <div class="table-action">
                    <a href="{{route('edit-topic-form', ['id' => $topic->id])}}" type="button" class="btn btn-warning">Edit</a>
                    <form action="{{route('delete-topic', ['id' => $topic->id])}}" method="POST">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
    </table>
    <div class="admin-paginate">
        {{$topics->links()}}
    </div>
</div>
@endsection