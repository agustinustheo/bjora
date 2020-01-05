@extends('layout.application')
@section('content')

<br><br>
<div class="border rounded p-3 mb-3">
    <div class="d-flex align-items-center">
        <div class="rounded-circle bg-dark display-picture">
            <img src="{{ URL::asset($user->profile_picture) }}">
        </div>
        <div class="ml-2">
            <h3>{{ $user->name }}</h3>
            <div>
                <span>{{  $user->email  }}</span><br>
               <span>{{  $user->address  }}</span> <br>
                <span>{{  $user->birthday  }}</span>
            </div>
            @if (Auth::check()  && Auth::user()->id==$user->id)
            <div class="d-flex">
                <a class="d-block bg-warning text-dark rounded p-1 ml-1 answer-delete pl-2 pr-2" href="/profile/edit">Update Profile</a>
            </div>
            @endif
        </div>
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