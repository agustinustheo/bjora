@extends('layout.application')
@section('content')
    <div class="center-single-div pt-5 pb-5">
        <div class="container col-md-6 bg-light rounded">
            <form class="form-group" method="POST" action="/topic/edit">
                {{ csrf_field() }}
                <h2 class="text-center">Edit Topic</h2>
                <div class="input-group p-2">
                    <input type="text" class="form-control" placeholder="Topic" name="topic">
                </div>
                <div class="input-group p-2">
                    <input type="submit" class="btn btn-danger login-btn btn-block">
                </div>
            </form>
        </div>
    </div>
@endsection