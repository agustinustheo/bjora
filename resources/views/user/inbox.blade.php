@extends('layout.application')
@section('content')
    @if($data_message->count()>0)
        @foreach($data_message as $message)
        <div class="border rounded p-3 mb-3 mt-4">
            <div class="d-flex align-items-start justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="rounded display-picture profile-display-pic">
                        <img src="{{ URL::asset($message->profile_picture) }}">
                    </div>
                    <div class="ml-2">
                        <h3>{{ $message->user_name }}</h3>
                        <div>
                            <span><b>Posted At:</b> {{ $message->created_at }}</span>
                            <br>
                            <span><b>Message:</b> {{ $message->message }}</span>
                        </div>
                    </div>
                </div>
                <a class="btn btn-danger text-white mt-2" href="/inbox/delete/{{ $message->id }}">
                    Remove
                </a>
            </div>
        </div>
        @endforeach
        {{ $data_message->links() }}
    @endif
@endsection