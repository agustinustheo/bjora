@extends('layout.application')
@section('content')
    <div class="center-single-div pt-5 pb-5">
        <div class="container col-md-6 bg-light rounded">
            <form class="form-group" method="POST" action="/login">
                {{ csrf_field() }}
                <h2 class="text-center">Log In</h2>
                <div class="input-group p-2">
                    <input type="text" class="form-control" placeholder="Email" name="email">
                </div>
                <div class="input-group p-2">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                </div>
                <div class="input-group px-2">
                    <label><input type="checkbox" name="remember"> Remember me</label>
                </div>
                <div class="input-group p-2">
                    <input type="submit" class="btn btn-danger login-btn btn-block">
                </div>
            </form>
        </div>
    </div>
@endsection