@extends('layout.application')
@section('content')
    <div class="border rounded-top p-3 mt-4">
        <div class="d-flex align-items-center justify-content-between">
            <span class="d-block text-muted">{{ $Question->topic_name }}</span>
            <div class="d-flex">
                @if ($Question->status!=1)
                <span class="d-block bg-warning rounded p-1 ml-1">Closed</span>
                @endif
                <span class="d-block bg-success text-white rounded p-1 ml-1">Open</span>
            </div>
        </div>
        <h3>{{ $Question->question }}</h3>
        <div class="d-flex align-items-center mb-3">
            <div class="rounded-circle bg-dark display-picture">
                <img src="{{ URL::asset('img/'.$Question->profile_picture) }}">
            </div>
            <div class="ml-2">
                <div class="text-danger">{{ $Question->user_name }}</div>
                <div>
                    <span class="font-weight-bold text-dark">Created At:</span>
                    <span class="text-muted">{{ $Question->created_at }}</span>
                </div>
            </div>
        </div>
        @if($Answers->count()>0)
            @foreach($Answers as $value)
            <div class="border rounded p-3 m-2">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-dark display-picture">
                            <img src="{{ URL::asset('img/'.$value->profile_picture) }}">
                        </div>
                        <div class="ml-2">
                            <div class="text-danger">{{ $value->user_name }}</div>
                            <div>
                                <span class="text-muted">Answered At: {{ $value->created_at }}</span>
                            </div>
                        </div>
                    </div>
                    @if ($Question->status==1  && session()->has('user')  && Session::get('user')==$value->user_id)
                    <div class="d-flex">
                        <a class="d-block bg-warning text-dark rounded p-1 ml-1 answer-delete pl-2 pr-2" href="/answer/edit/{{ $value->id }}">Edit</a>
                        <a class="d-block bg-danger text-white rounded p-1 ml-1 answer-delete" href="/answer/delete/{{ $value->id }}">Delete</a>
                    </div>
                    @endif
                </div>
                <p class="mt-2">
                    {{ $value->answer }}
                </p>
            </div>
            @endforeach
        @endif
    </div>
    @if ($Question->status==1 && session()->has('user'))
    <form class="border border-top-0 rounded-bottom pt-3 pr-3 pl-3 pb-2" method="POST" action="/answer/add">
        {{ csrf_field() }}
        <input type="hidden" class="form-control" name="question_id" value="{{ $Question->id }}">
        <div class="input-group p-2">
            <textarea class="form-control" placeholder="Your answer..." name="answer" rows="5"></textarea>
        </div>
        <div class="input-group p-2">
            <input type="submit" class="btn btn-danger text-white" value="Answer">
        </div>
    </form>
    @endif
@endsection