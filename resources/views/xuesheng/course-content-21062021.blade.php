<?php 
    use App\Models\Lecture; 
    use App\Models\Media; 
?>
@extends('layouts.guest')

@section('page-css')
<style>
    .rating:hover {
        color: #ffc107 !important;
    }
    
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container-fluid mb-5">
    <div class="d-flex justify-content-between my-2">
        <h1 class="text-capitalize my-3"> {{ $course->course_title ?? '' }} </h1>
        <section id="rating" class="d-flex align-items-center" style="cursor: pointer">
            <span class="fa fa-2x fa-star rating" no="1"></span>
            <span class="fa fa-2x fa-star ml-1 rating" style="text-size: 1.3rem;" no="2"></span>
            <span class="fa fa-2x fa-star ml-1 rating" style="text-size: 1.3rem;" no="3"></span>
            <span class="fa fa-2x fa-star ml-1 rating" style="text-size: 1.3rem;" no="4"></span>
            <span class="fa fa-2x fa-star ml-1 rating" style="text-size: 1.3rem;" no="5"></span>
        </section>
    </div>
    <div class="row">
        <div class="col-md-3 border p-2">
            @php isset($course) ? $sections = $course->sections : abort(500); @endphp
            @if($sections)
            @foreach ($sections as $sec)
            <ul class="ml-4 mt-2 list-group">
                <h4 class="text-capitalize font-bold mb-4"> {{ $sec->section_title ?? '' }} </h4>
                @php $lectures = Lecture::where([['course_id', $course->id],['sec_no' ,'=', $sec->section_no]])->get();
                @endphp

                @if($lectures->count())
                @foreach ($lectures as $lec)
                @php $video = $lec->media; @endphp

                @if($video)
                <li class=" list-group-item mt-2 py-2 pl-3 @if($video->id === $media->id) bg-static-website @endif">
                    <section class="d-flex justify-content-between">
                        <a class="text-capitalize d-block @if($video->id === $media->id) text-white @endif"
                            href="{{route('video-page', ['slug' => $course->slug, 'video' => explode('/',$video->lec_name)[1]])}}">
                            <i class="fa fa-play mr-2"
                                aria-hidden="true"></i>{{ reduceCharIfAv($lec->lec_name ?? '',40) }}
                        </a>
                        <span class="mr-1"> {{ $video->duration ?? ''}} </span>
                    </section>
                </li>
                @endif
                @endforeach
                @endif
            </ul>
            @endforeach
            @endif
            <form action="{{route('getCerti')}}" method="get">
                @csrf
                <input type="hidden" name="c_name" value="{{ $course->course_title ?? '' }}" />
                <button type="submit" class="btn btn-website btn-lg mt-5 ml-4"> Get Your Certificate </button>
            </form>
        </div>
        <div class="col-md-9">
            @php
            $id = $media->lecture_id;
            $course_id = $media->course_id;
            $next_media = Media::where('lecture_id', $id+1)->where('course_id',$course_id)->first();
            @endphp
            @if($next_media)
            <div class="d-flex justify-content-end my-2">
                <a href="{{route('video-page' , ['slug' => $course->slug, 'video' => explode('/',$next_media->lec_name)[1]])}}"
                    class="btn btn-lg btn-website"> Next </a>
            </div>
            @endif
            <video controls class="w-100" oncontextmenu="return false;">
                <source src="{{'https://lyskills-by-nouman.s3.ap-southeast-1.amazonaws.com/'}}{{$media->lec_name}}"
                    type="{{$media->f_mimetype ?? '' }}">
                Your browser does not support the video tag. Please choose latest Google Chrome, Firefox , Opera Browser
            </video>

            <div class="my-5">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <h3> About Course </h3>
                            <div class="pl-3 mt-2">
                                <h4 class="text-capitalize my-2"> {{ $course->course_title ?? '' }} </h4>
                                <div class="my-2"> {{ $course->categoires_selection ?? '' }} </div>
                                <div class="my-2"> {{ $course->description ?? '' }} </div>
                                <div class="my-2">{{ $course->c_level ?? '' }} </div>
                                <div class="my-2"> <a href="{{route('user-course',['slug' => $course->slug])}}"
                                        class="btn btn-website"> Course Link </a> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="nav nav-pills" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#public" role="tab"
                        aria-controls="public" aria-selected="true">Public Announcement</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="public" role="tabpanel" aria-labelledby="home-tab">
                    @if($c_anns->count())
                    <h2 class="text-center"> Announcements </h2>
                    @foreach ($c_anns as $ann)
                    <section class="border p-3 mt-3">
                        <h3>
                            {{ $ann->subject ?? '' }}
                        </h3>
                        <div>
                            {{ $ann->body ?? '' }}
                        </div>
                    </section>
                    @endforeach
                    @else
                    <div class="ml-3 mt-2"> No Announcement was made yet </div>
                    @endif

                </div>
            </div>

            @php $ex_youtube_res = $m_lec->ex_res; @endphp
            @if ($ex_youtube_res && $ex_youtube_res->title)
            <div class="my-5">
                <div class="container">
                    <h3 class="mb-4"> Extra Resource That might help </h3>
                    <div> {{ $ex_youtube_res->title }} </div>
                    <iframe class="w-100" height="300" src="{{ $ex_youtube_res->link }}" title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer;  clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            </div>
            @endif

            @php $extra_vid = $m_lec->res_vid; @endphp
            @if($extra_vid)
            <div class="my-5">
                <div class="container">
                    <h3 class="mb-2">
                        Extra Recommended Video
                    </h3>
                    <video controls class="w-100" oncontextmenu="return false;">
                        <source
                            src="{{'https://lyskills-by-nouman.s3.ap-southeast-1.amazonaws.com/'}}{{$extra_vid->lec_path}}"
                            type="{{$extra_vid->f_mimetype ?? '' }}">
                        Your browser does not support the video tag. Please choose latest Google Chrome, Firefox , Opera
                        Browser
                    </video>
                </div>
            </div>

            @endif

            @php $article = $m_lec->article; @endphp
            @if($article)
            <div class="my-5">
                <div class="container">
                    <h3 class="mb-2">
                        Recommended Article
                    </h3>
                    <textarea rows="10" class="form-control">
                                {{ $article ->article_txt ?? '' }}
                            </textarea>
                </div>
            </div>
            @endif

            @php $other_file = $m_lec->other_file; @endphp
            @if($other_file)
            <div class="my-5">
                <div class="container">
                    <h3 class="mb-2">
                        Recommended Material to read offline
                    </h3>
                    <a href="{{asset('storage/'.$other_file->f_path)}}" download="download"
                        class="btn btn-website mt-2">
                        {{$other_file->f_name}}
                    </a>
                </div>
            </div>
            @endif
            @if($next_media)
            <div class="d-flex justify-content-end my-2">
                <a href="{{route('video-page' , ['slug' => $course->slug, 'video' => explode('/',$next_media->lec_name)[1]])}}"
                    class="btn btn-lg btn-website"> Next </a>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection

@section('script')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
</script>

<script>
    $(".rating").click( function(){
        let rating_no = $(this).attr('no');
        $.ajax({
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "{{route('rating-course')}}",
        data: {rating_no:  rating_no, course: '{{$course->slug}}'  },        
        dataType: "json",        
        success: function(result){
            if(result.message){
                $('.rating').each(function(index){
                    if(index<rating_no){
                        $(this).addClass('text-warning');
                    }else{
                        $(this).removeClass('text-warning');
                    }
                })
            }            
        }
    });
    });

    var rating = '@if ($course->rating) {{$course->rating->rating}} @endif';
    $('.rating').each(function(index){
                    if(index<rating){
                        $(this).addClass('text-warning');
                    }else{
                        $(this).removeClass('text-warning');
                    }
                });
</script>

@endsection