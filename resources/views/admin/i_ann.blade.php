@extends('admin.admin_main')
@section('page-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <x-create-notification>
        <section>
            <h1> Create Notification 
            </h1>
            <hr/>
        </section>
        <x-slot name="createNotifcationForm">
        <form action="{{route('p_info')}}" method="POST">                
                @include('session_msg')
                @csrf
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
                  <label for="message">Message </label>
                  <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="10"                  
                  placeholder="Enter the message">{{old('message')}}</textarea>                                    
                </div>                
                <button type="submit" class="btn btn-primary"> Make Live </button>
              </form>
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




