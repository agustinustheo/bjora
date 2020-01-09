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
        <a class="btn btn-danger text-white mt-2" href="/profile/edit">
            Update Profile
        </a>
    </div>
</div>
@endsection