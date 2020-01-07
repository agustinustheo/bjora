@extends('layout.application')
@section('content')
@if($question_data->count()>0)
@foreach($question_data as $data)
<div class="border rounded-top p-3 mt-4">
        <div class="d-flex align-items-center justify-content-between">
            <span class="d-block text-muted">{{ $data->topic_name }}</span>
            <div class="d-flex">
                @if ($data->status!=1)
                <span class="d-block bg-warning rounded p-1 ml-1">Closed</span>
                @endif
                <span class="d-block bg-success text-white rounded p-1 ml-1">Open</span>
            </div>
        </div>
        <h3>{{ $data->question }}</h3>
        <div class="d-flex align-items-center mb-3">
            <div class="rounded-circle bg-dark display-picture">
                <img src="{{ URL::asset(Auth::user()->profile_picture) }}">
            </div>
            <div class="ml-2">
                <a href="{{'/profile/'.Auth::user()->id}}" class="text-danger">{{ Auth::user()->name }}</a>
                <div>
                    <span class="font-weight-bold text-dark">Created At:</span>
                    <span class="text-muted">{{ $data->created_at }}</span>
                </div>
            </div>
        </div>

</div>
@endforeach
@else
<h1>No Questions Found</h1>
@endif
@endsection