@extends('layout.application')
@section('content')

@if($data_message->count()>0)
            @foreach($data_message as $message)
            <div class="border rounded p-3 m-2">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-dark display-picture">
                            {{-- <img src="{{ URL::asset($message->profile_picture) }}"> --}}
                        </div>
                        <div class="ml-2">
                            {{-- <div class="text-danger">{{ $message->user_name }}</div> --}}
                            <div>
                                <span class="text-muted">Posted At: {{ $message->created_at }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex">
                        {{-- <a class="d-block bg-danger text-white rounded p-1 ml-1 answer-delete" href="/answer/delete/{{ $value->id }}">Delete</a> --}}
                    </div>
                </div>
                <p class="mt-2">
                    {{ $message->message }}
                </p>
            </div>
            @endforeach
        @endif
    </div>


@endsection