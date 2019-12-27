@extends('layout.manage')
@section('content')
    <div class="center-single-div pt-5 pb-5">
        <div class="container col-md-6 bg-light rounded">
            <form class="form-group" method="POST" action="/question/edit">
                {{ csrf_field() }}
                <h2 class="text-center">Edit Question</h2>
                <input type="hidden" class="form-control" name="id" value="{{ $Question->id }}">
                <div class="input-group p-2">
                    <textarea class="form-control {{ $errors->has('question') ? 'is-invalid' : ''}}" placeholder="Question" name="question" rows="3">{{ $Question->question }}</textarea>
                </div>
                {!! $errors->first('question', '<span class="text-danger pl-2 text-danger-size">:message</span>') !!}
                <div class="input-group p-2">
                    <select class="form-control" placeholder="Topic" name ="topic">
                        @foreach($Topics as $value)
                        <option value="{{ $value->id }}" {{ $Question->topic_id === $value->id ? "selected='selected'" : "" }}>{{ $value->name }}</option>
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