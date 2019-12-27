@extends('layout.manage')
@section('content')
    <div class="center-single-div pt-5 pb-5">
        <div class="container col-md-6 bg-light rounded">
            <form class="form-group" method="POST" action="/answer/edit">
                {{ csrf_field() }}
                <h2 class="text-center">Edit Answer</h2>
                <input type="hidden" class="form-control" name="id" value="{{ $Answer->id }}">
                <div class="input-group p-2">
                    <textarea class="form-control {{ $errors->has('answer') ? 'is-invalid' : ''}}" placeholder="Answer" name="answer" rows="7">{{ $Answer->answer }}</textarea>
                </div>
                {!! $errors->first('answer', '<span class="text-danger pl-2 text-danger-size">:message</span>') !!}
                <div class="input-group p-2">
                    <input type="submit" class="btn btn-danger login-btn btn-block">
                </div>
            </form>
        </div>
    </div>
@endsection