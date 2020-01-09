@extends('layout.application')
@section('content')

<br><br>
<div class="border rounded p-3 mb-3">
    <div class="d-flex align-items-start justify-content-between">
        <div class="d-flex align-items-center">
            <div class="rounded bg-dark display-picture profile-display-pic">
                <img src="{{ URL::asset($user->profile_picture) }}">
            </div>
            <div class="ml-2">
                <h3>{{ $user->name }}</h3>
                <div>
                    <span>{{  $user->email  }}</span>
                    <br>
                    <span>{{  $user->address  }}</span>
                    <br>
                    <span>{{  $user->birthday  }}</span>
                </div>
            </div>
        </div>
        @if (Auth::check()  && Auth::user()->id==$user->id)
        <a class="btn btn-danger text-white mt-2" href="/profile/edit">
            Update Profile
        </a>
        @endif
    </div>
</div>

@if (Auth::check() && Auth::user()->id!=$user->id)
    <form class="border border-top-0 rounded-bottom pt-3 pr-3 pl-3 pb-2" method="POST" action="/profile/message">
        {{ csrf_field() }}
        <input type="hidden" class="form-control" name="sender_id" value="{{ Auth::user()->id }}">
        <input type="hidden" class="form-control" name="receiver_id" value="{{ $user->id }}">
        <div class="input-group p-2">
            <textarea class="form-control {{ $errors->has('message') ? 'is-invalid' : ''}}" placeholder="" name="message" rows="5"></textarea>
        </div>
        {!! $errors->first('message', '<span class="text-danger pl-2 text-danger-size">:message</span>') !!}
        <div class="input-group p-2">
            <input type="submit" class="btn btn-danger text-white" value="Send message">
        </div>
    </form>
    @endif


</div>
@endsection