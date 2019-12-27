@extends('layout.manage')
@section('content')
    <div class="pt-5">
        <a class="btn btn-danger text-white p-1" href="/question/add">
            Add Question
        </a>
        <h1>Manage Question</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Topic</th>
                    <th scope="col">Owner</th>
                    <th scope="col">Question</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($Questions as $value)
                <tr>
                    <th scope="row">{{ $loop->index+1 }}</th>
                    <td>
                        {{ $value->topic_name }}
                    </td>
                    <td>
                        {{ $value->user_name }}
                    </td>
                    <td>
                        <a class="text-danger" href="/answer/{{$value->id}}">
                            {{ $value->question }}
                        </a>
                    </td>
                    <td>
                        @if($value->status==1)
                            <span class="d-block bg-success text-white rounded p-1 ml-1">Open</span>
                        @else
                            <span class="d-block bg-warning rounded p-1 ml-1">Closed</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex">
                            @if($value->status==1)
                                <a class="d-block bg-secondary text-white rounded p-1 ml-1 answer-delete" href="/question/status/{{ $value->id }}">Closed</a>
                            @else
                                <a class="d-block bg-success text-white rounded p-1 ml-1 answer-delete" href="/question/status/{{ $value->id }}">Open</a>
                            @endif
                            <a class="d-block bg-warning rounded text-dark p-1 ml-1 answer-delete" href="/question/edit/{{ $value->id }}">Edit</a>
                            <a class="d-block bg-danger text-white rounded p-1 ml-1 answer-delete" href="/question/delete/{{ $value->id }}">Delete</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $Questions->links() }}
    </div>
@endsection