@extends('admin.admin_main')
@section('page-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <x-create-notification>
        <section>
            <h1> Edit Notification 
            </h1>
            <hr/>
            <div class="d-flex justify-content-end">
                <a href="{{route('s_info_user')}}" class="btn btn-info btn-lg">
                    Back to All Notification 
                </a>
            </div>
        </section>
        <x-slot name="createNotifcationForm">
            
            @if(isset($instructor) && $instructor->count())                
            
            @foreach ($instructor  as $i)
                
            
        <form action="{{route('____edit_user',['i' => $i->id ?? abort(500)])}}" method="POST">                
                @include('session_msg')
                @csrf
                @method('put')
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li> {{ $error }} </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group">
                  <label for="message"> Message </label>
                  <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="10"                  
                  placeholder="Enter the message">{{$i->message ?? ''}}</textarea>                                    
                </div>                
                <button type="submit" class="btn btn-primary"> Update && Go Live </button>
        </form>
            @endforeach
              @endif
        </x-slot>
    </x-create-notification>    
@endsection


@section('page-js')
    <script>
        $(function(){
            function makeVanish(){
                $('textarea').removeClass('is-invalid');
                $('.alert').fadeOut();
            }
            setTimeout(() => {
                makeVanish();
            }, 10000);

            $('textarea').click(function(){
                makeVanish();
            })
        });
    </script>
@endsection




