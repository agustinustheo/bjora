@extends('layout.manage')
@section('content')
    <div class="center-single-div pt-5 pb-5">
        <div class="container col-md-6 bg-light rounded">
            <form class="form-group" method="POST" action="/question/add">
                {{ csrf_field() }}
                <h2 class="text-center">Add Question</h2>
                <div class="input-group p-2">
                    <textarea class="form-control" placeholder="Question" name="question" rows="3"></textarea>
                </div>
                <div class="input-group p-2">
                    <select class="form-control" placeholder="Topic" name ="topic">
                        @foreach($Topics as $value)
                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group p-2">
                    <input type="submit" class="btn btn-danger login-btn btn-block">
                </div>
            </form>
        </div>
    </div>
@endsection