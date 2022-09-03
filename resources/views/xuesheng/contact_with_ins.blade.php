@extends('layouts.guest')


@section('content')
    <div class="container">
        <h1>
            Contact with Your Course Instructor
        </h1>
        <div class="container my-5">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    @include('session_msg')
                    <h2 class="text-center mb-3">
                        Leave Message to your Instructor by selecting your enrolled course
                    </h2>
                    <form action="{{route('con-ins-post')}}" method="POST">
                        @csrf         
                          <div class="form-group">
                            <label for="course">Select Course</label>
                            <span class="text-danger my-1 d-block">If no course is found in the select option which mean you are not enrolled in any course </span>
                            <select class="custom-select @error('course') is-invalid @enderror" name="course">
                                @if(count($c_titles))
                                @foreach ($c_titles as $title)
                                <option value="{{$title}}"> {{ str_replace('-',' ',$title) }} </option>                                                                    
                                @endforeach
                                @endif
                            </select>  
                            @error('course')
                            <div class="alert alert-danger">{{ $message }}</div>
                    @enderror                          
                        </div>
                        <div class="form-group">
                          <label for="body"> Message* </label>
                          <textarea class="form-control @error('body') is-invalid @enderror" id="body" name="body" placeholder="body" rows="15">{{old('body')}}</textarea>
                          @error('body')
                                <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        </div>       
                        <button type="submit" class="btn btn-website btn-lg">Send Message </button>
                      </form>
                </div>
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