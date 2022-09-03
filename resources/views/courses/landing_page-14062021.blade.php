@extends('courses.dashboard_main')
@php

use App\Models\LanguageModal;
@endphp
@section('page-css')

@section('content')

<div class="border bg-white col-md-9 mt-3">
    <section class="container p-3">
        @include('session_msg')
        <div class=" page-heading ">
            <h1> Landing Page </h1>
            <hr />
        </div>

        <form url="{{route('landing_page_post', compact('course'))}}" class="landing_form">
            <div id="show_status" class="text-success text-center"></div>
            <div class="form-group">
                <label for="course_title">Course Title</label>
                <input type="text" class="form-control" id="course_title" title="Input your course title"
                    placeholder="Course Title" name="course_title" value="{{$course->course_title ?? ''}}"
                    {{-- @if($course->status == 'published') {{ __('disabled')}} @endif --}}>
                <div id="title_err" class="form-text text-danger"></div>
            </div>
            <div class="form-group">
                <label for="course_desc"> Course Description </label>
                <textarea class="form-control" id="course_desc" rows="10" cols="10" name="course_desc"
                    title="Input your course description"
                    placeholder="Course Description">{{$course->description ?? ''}}</textarea>
                <div id="desc_err" class="form-text text-danger"></div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <select class="js-example-responsive js-states form-control" id="select_level" name="select_level">
                        <option value="">Select Level </option>
                        @php $c_level = $course->c_level; @endphp
                        <option value="beginner" @if($c_level==='beginner' ) {{ __('selected')}} @endif> Beginner
                        </option>
                        <option value="intermediate" @if($c_level==='intermediate' ) {{ __('selected')}} @endif>
                            Intermediate </option>
                        <option value="advance" @if($c_level==='advance' ) {{ __('selected')}} @endif> Advance </option>
                        <option value="all_level" @if($c_level==='all_level' ) {{ __('selected')}} @endif> All level
                        </option>
                    </select>
                    <div id="c_level" class="form-text text-danger"></div>

                </div>
                <div class="col-md-6 mt-3 mt-md-0">
                    <select class="js-example-responsive js-states form-control" id="select_category" name="select_category">
                        <option value=""> Select Category </option>
                        @php $c_category = $course->categories_selection; @endphp
                        @if(isset($categories) && $categories)
                        @foreach ($categories as $c)
                        <option value="{{$c->value ?? null}}" @if($c_category===$c->value) {{ __('selected')}} @endif >
                            {{$c->name ?? null}} </option>
                        @endforeach
                        @endif
                    </select>
                    <div id="category_level" class="form-text text-danger"></div>

                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <select class="js-example-responsive js-states form-control" id="lang" name="lang" style="height: 2rem !important">
                            <option value=""> Select Language </option>
                            @php $langs = LanguageModal::select('id','name')->get();

                            @endphp
                            @if(isset($langs) && $langs)
                            @foreach ($langs as $lang)
                            <option value="{{$lang->id ?? null}}" @if(isset($course) && $course->lang_id === $lang->id)
                                {{ __('selected')}} @endif >
                                {{$lang->name ?? null}} </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="">
                        <div id="lang_err" class="text-danger"></div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    {{-- @if($course->status === "published") {{ __('disabled')}} @endif --}}
                    <button type="submit" class="float-right btn btn-lg btn-info"> <i class="las la-save"></i> Save
                    </button>
                </div>
            </div>

        </form>
    </section>

    <hr>
    <section class="course_img">
        <div class=""> Course Image </div>
        <div class="row">
            <div class="col-md-6">
                @php $course_img = $course->course_image;
                $path = null;
                if($course_img){
                $path = $course_img->image_path;
                }
                @endphp
                <img src="@if($path) {{asset('storage/'.$path)}} @else {{asset('img/thumbnail.jpg')}} @endif"
                    alt="Course Thumbnail" class="img-fluid course_img" width="750" height="450" />
            </div>
            <div class="col-md-6">
                <section class="d-flex justify-content-center align-items-center flex-column h-100">

                    <div class="text-info text-left w-100" style="  text-align: left !important "> Please upload a Image
                        of format jpeg,png,jpg,gif,tif</div>
                    <section class="img_con mt-3 w-100">
                        <form>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input upload_img" id="customFile"
                                    name="course_img" url="{{route('course_img',compact('course'))}}">
                                <label class="custom-file-label" for="customFile">Upload Image</label>
                            </div>
                        </form>
                        <div class="progress mt-3 p_bar_con d-none">
                            <div class="progress-bar p_bar" style="width: 0%" role="progressbar" aria-valuenow="0"
                                aria-valuemin="0" aria-valuemax="100">0%</div>
                        </div>
                        <div class="text-danger img_err"> </div>
                    </section>

                </section>
            </div>
        </div>
    </section>

    <hr>
    <section class="course_vid my-5">
        <div> Course Video </div>
        <div class="row">
            <div class="col-md-6">
                @php
                $course_vid = $course->course_vid;
                $vid_path = null;
                if($course_vid){
                $vid_path = $course_vid->vid_path;
                }
                @endphp
                @if($vid_path)
                <video width="450" height="350" controls>
                    <source src="{{asset('storage/'.$vid_path)}}" type="{{$course_vid->video_type}}">
                </video>
                @else
                <img src="{{asset('img/thumbnail.jpg')}}" alt="Course Thumbnail" class="img-fluid video_img" width="750"
                    height="450" />
                @endif
            </div>
            <div class="col-md-6 align-items-center">
                <section class="d-flex justify-content-center align-items-center flex-column h-100">
                    <div class="text-info w-100"> Please upload a video of <span class="text-danger">
                            mp4,ogg,webm format</span> with at most 1GB size</div>
                    <section class="img_con mt-3 w-100">
                        <form>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input upload_vid" id="customFile"
                                    name="course_vid" url="{{route('course_vid',compact('course'))}}">
                                <label class="custom-file-label" for="customFile">Upload Video</label>
                            </div>
                        </form>
                        <div class="progress mt-3 vid_p_con d-none">
                            <div class="progress-bar vid_p_bar" style="width: 0%" role="progressbar" aria-valuenow="0"
                                aria-valuemin="0" aria-valuemax="100">0%</div>
                        </div>
                        <div class="text-danger vid_err"> </div>
                    </section>
                </section>
            </div>
        </div>
    </section>
    {{-- <hr/> --}}


</div>
@endsection


@section('page-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<script>
    // $(document).ready(function() {
        

    // });  
    
</script>
<script src="{{asset('js/landing_page.js')}}">
</script>
<script>
    $('input').click(function(){
            $('.alert').fadeOut();
            $(this).removeClass('is-invalid');

        });

        
        setTimeout(() => {
                $('.alert').fadeOut();
            }, 5000);
</script>

@endsection