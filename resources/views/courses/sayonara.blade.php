@extends('courses.dashboard_main')
@php 


$sayonara = $course->sayonara;


@endphp


@section('content')
<div class="border bg-white col-md-9 mt-3 p-3">
    <section class="sayonara">
        <h1> Final Step </h1>
        <hr>

        <form url="{{route('zaijianPost', compact('course'))}}" class="final_form">
            <div class="text-success success_msg text-center"></div>
            <div class="form-group">
                <label for="wel_msg"> Welcome Message </label>
                <textarea class="form-control" id="wel_msg" name="wel_msg"  rows="7"  placeholder="Welcome Message (1000 words are allowed)">@if($sayonara) {{ $sayonara->welcome_msg ?? ''}} @endif</textarea>
                <div id="wel_err" class="text-danger"></div>
            </div>
            <div class="form-group">
                <label for="congo_msg">Congtratulation Message</label>
                <textarea class="form-control" id="congo_msg" name="congo_msg"  rows="7" placeholder="Congtratulation Message (1000 words are allowed)">@if($sayonara) {{ $sayonara->congo_msg ?? ''}} @endif</textarea>
                <div id="congo_err" class="text-danger"></div>
            </div>
            <button type="submit" class="btn btn-info btn-lg"><i class="las la-save"></i>Save</button>

        </form>
    </section>
    <hr>
    <section class="my-2">
        <h2> Course URL </h2>
        @if($course->has_u_update_url || $course->status == "published")
            <div > <a href="{{ route('user-course', ['slug' => $course->slug]) }}"> Course URL </a> </div>
        @else 
            {{-- <h5 class="mt-3" > Customize URL </h5> --}}
            <div class="mt-2"> You can definately change your URL if you wish but you can only change it once. 
                Please do it, if you think your url is not suitable for your students. <p class="text-danger"> Please make sure, you can 
                    only change it once. </p> 
            </div>

            <form action="{{route('course-change-url', ['course' => $course->id])}}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" >https://lyskills.com/course/</span>
                    </div>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror" placeholder="url" aria-label="url" aria-describedby="url"
                            name="slug" id="slug" value="@if(old('slug')) {{ old('slug') }} @else {{$course->slug}} @endif"
                    >
                </div>
                @error('slug')
                    <div class="alert alert-danger"> {{ $message }} </div>
                @enderror
                <input type="submit" class="btn btn-info" value="Update URL" />
            </form>
        @endif
    </section>
</div>
@endsection



@section('page-js')
    <script src="{{asset('js/message.js')}}">        
    </script>    
@endsection