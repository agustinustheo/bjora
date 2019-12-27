@extends('layout.manage')
@section('content')
    <div class="center-single-div pt-5 pb-5">
        <div class="container col-md-6 bg-light rounded">
            <form class="form-group" method="POST" action="{{route('edit-topic')}}">
                {{ csrf_field() }}
                <h2 class="text-center">Edit Topic</h2>
                <div class="input-group p-2">
                    <input type="text" value="{{$topic->name}}" class="form-control" placeholder="Topic Name" name="name">
                </div>
                {!! $errors->first('name', '<span class="text-danger pl-2 text-danger-size">:message</span>') !!}
                <input type="hidden" value="{{$topic->id}}" name="id">
                <div class="input-group p-2">
                    <input type="submit" class="btn btn-danger login-btn btn-block">
                </div>
            </form>
        </div>
    </div>
@endsection