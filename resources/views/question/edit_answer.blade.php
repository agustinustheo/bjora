@extends('layout.application')
@section('content')
    <div class="center-single-div pt-5 pb-5">
        <div class="container col-md-6 bg-light rounded">
            <form class="form-group" method="POST" action="/answer/edit">
                {{ csrf_field() }}
                <h2 class="text-center">Edit Answer</h2>
                <input type="hidden" class="form-control" name="id" value="{{ $Answer->id }}">
                <div class="input-group p-2">
                    <textarea class="form-control" placeholder="Answer" name="answer" rows="7">{{ $Answer->answer }}</textarea>
                </div>
                <div class="input-group p-2">
                    <input type="submit" class="btn btn-danger login-btn btn-block">
                </div>
            </form>
        </div>
    </div>
@endsection