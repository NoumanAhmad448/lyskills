@php

use App\Models\User;
@endphp

@extends('layouts.dashboard_header')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <h1> {{ $course_name}} </h1>

            @if ($comms->count())
            @foreach ($comms as $c)
            @php $user = User::where('id', $c->user_id)->first(); @endphp
            <section class="row my-3 ml-3">
                <div class="col-2">
                    <img height="50" width="50" class="rounded-circle object-cover" src="@if($user->profile_photo_path) {{ asset($user->profile_photo_path) }} @else
            {{ $user->profile_photo_url }} @endif" alt="{{ $user->name }}" />
                </div>
                <div class="col">
                    <div style="font-weight: bold" class="text-capitalize">{{$user->name}}</div>
                    <div class="mb-2">{{$c->comment}}</div>
                    
                    <div onClick="deleteComment({{$c->id}})" class="cursor_pointer text-danger">delete</i>
                    
                </div>
            </section>
            @endforeach
            @else
            <div class="text-center"> no comments </div>
            @endif
        </div>
    </div>
</div>

@section('page-js')
    <script>
        function deleteComment(msg){
                    // console.log('working');
                    if(confirm("Are you sure to delete this comment")){
                        let message_id = msg;
                        // console.error(message_id);
                        $.ajax({
                            url: "{{route('laoshi-commentDelete')}}",
                            type: 'post',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {message_id: message_id },
                            success: function(){
                                location.reload();
                            }

                        });
                    }
                }
    </script>
@endsection

@endsection

