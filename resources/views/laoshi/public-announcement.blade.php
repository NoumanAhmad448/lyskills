@extends('layouts.dashboard_header')
@section('page-css')
    <style>
        .star-red{
            color: #f00;
        }
    </style>
@endsection

@section('page-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection 


@section('content')
    <div class="container">
        <h1>
            Public Announcement to User
        </h1>
        <div>
            Send a announcement to your users via email and show them this in your courses
        </div>
        <hr>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                @include('session_msg')
                <form action="{{route('public-ann-post')}}" method="POST">
                    @csrf                   
                    <div class="form-group">
                      <label for="courses"> Select Courses<span class="star-red"> *</span> </label>
                      <select class="custom-select" multiple name="courses[]" id="courses">                        
                        @if ($courses)
                            @foreach ($courses as $course)
                                <option value="{{$course->slug}}"> {{ $course->course_title }} </option>                                                       
                            @endforeach
                        @endif
                      </select>
                      @if ($errors->has('courses'))
                          <div class="alert alert-danger">                                                               
                                {{ $errors->first('courses') }}                           
                          </div>
                      @endif
                      {{-- @error('courses')
                            <div class="alert alert-danger">{{ $message }}</div>
                    @enderror --}}
                    </div>

                    <div class="form-group">
                      <label for="subject"> Subject<span class="star-red"> *</span> </label>
                      <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" placeholder="Subject"
                      value="{{old('subject')}}">
                      @error('subject')
                            <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
            
                    <div class="form-group">
                      <label for="body"> Email Body<span class="star-red"> *</span></label>
                      <textarea class="form-control @error('body') is-invalid @enderror" id="body" name="body" placeholder="body" rows="20">{{old('body')}}</textarea>
                      @error('body')
                            <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>       
                    <button type="submit" class="btn btn-website btn-lg">Send Announcement </button>
                  </form>
            </div>
        </div>
    </div>
@endsection


@section('page-js')
<script>
    $(function(){
        $('input,textarea,select').click(function(){
            $('input,textarea,select').removeClass('is-invalid');
            $('.alert').fadeOut();
        });
    });
</script>
@endsection