<?php 
use App\Models\RatingModal;

?>
@extends('layouts.guest')
@section('page-css')
{{-- <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" /> --}}
    <style>
        /* fix-height */
        .fix-height{
                height: 23rem !important;
        }
        @media all and (max-width: 576px) {
            .fix-height{
                height: 26rem !important;
            }
        }
        
    </style>
@endsection
@section('content')
{{-- <section class="d-flex justify-content-center align-items-center loading-section">
    <div id="loading" class="spinner-border text-info text-center" style="width: 90px; height: 90px" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</section> --}}
@include('session_msg')
<div class="container-fluid" >
    <div class="row">
        <div class="col-md-10 offset-md-1" style="">
            <section style="position: relative">
                <img src="{{asset('img/student.jpg')}}" alt="student" class="img-fluid" style=""/>
            <a href="{{route('register')}}" class="btn  btn-outline-website d-none " 
                    style="position: absolute; top: 0;left: 0;"> Become an Instructor </a>
            </section>
        </div>
    </div>
</div>


@if($courses && $courses->count())
<div class="container-fluid my-5" style="">
    {{-- <h2> Available Courses </h2>         --}}                     
    <div class="d-flex justify-content-end">
        <a href="{{route('show-all-courses')}}" class="btn btn-website btn-lg">All Courses</a>
    </div>
    <div class="row mt-2 row-cols-md-5">
        @foreach ($courses as $course)
        <div class="col-12 col-md mt-2">
            @if($course->slug)
            <div class="card fix-height" style="">
                <a href="{{route('user-course', ['slug' => $course->slug])}}">
                    @if($course->course_image) <img class="card-img-top img-fluid"
                        src="{{ asset('storage/'.$course->course_image->image_path)}}"
                        alt="{{ $course->course_image->image_name }}"> @endif
                </a>

                @php 
                     $rating_avg = (int) RatingModal::where('course_id',$course->id)->avg('rating');
                    $rated_by_students = (int) RatingModal::where('course_id',$course->id)->count('rating');
                @endphp


                {{-- <div class="card-body" style="/height: 180px"> --}}
                <div class="card-body" style="height: 150px">
                    <h5 class="card-title font-bold text-capitalize" style="font-size: 1.1rem;font-weight:bold"> {{ reduceCharIfAv($course->course_title ?? '', 40)}} </h5>
                    <p class="card-text text-capitalize mb-0 mt-1"><span class=""> {{ reduceWithStripping($course->user->name,20) ?? '' }} </span>
                    </p>
                    <p class="mb-0 mt-1 @if($course->categories_selection == 'it') {{ 'text-uppercase' }} @else {{ 'text-capitalize'}} @endif">  {{ reduceWithStripping($course->categories_selection,20) ?? '' }} </p>
                    @if($rating_avg)
                    <div class="d-flex align-items-center">
                        <section id="rating" class="d-flex align-items-center" style="cursor: pointer">
                            {{$rating_avg}}

                            <span class="fa fa-star  @if($rating_avg >= 1) {{'text-warning'}}  @endif" no="1"></span>
                            <span class="fa fa-star ml-1  @if($rating_avg >= 2) {{'text-warning'}}  @endif" style="text-size: 1.3rem;" no="2"></span>
                            <span class="fa fa-star ml-1  @if($rating_avg >= 3) {{'text-warning'}}  @endif" style="text-size: 1.3rem;" no="3"></span>
                            <span class="fa fa-star ml-1  @if($rating_avg >= 4) {{'text-warning'}}  @endif" style="text-size: 1.3rem;" no="4"></span>
                            <span class="fa fa-star ml-1  @if($rating_avg >= 5) {{'text-warning'}}  @endif" style="text-size: 1.3rem;" no="5"></span>
                            <span class="ml-1">( {{ $rated_by_students}} )</span>
                        </section>                        
                    </div>                    
                    @endif
                    <p class="card-text text-capitalize  mb-0  mt-1 d-flex font-bold"> @if($course->price->is_free)
                        {{ __('free') }}
                        @else <span style="font-weight:bold"> ${{ $course->price->pricing ?? '' }} </span>
                        @php $total_p = ((int)$course->price->pricing)+20 @endphp
                        <del class="ml-2"> ${{ $total_p }} </del>
                        @endif
                    </p>
                </div>
            </div>
            @endif
        </div>
        @endforeach
    </div>

</div>
@endif

@if(isset($cs) && $cs->count())
<div class="container-fluid my-4">
    <h2> All Categories </h2>
    <div class="row my-2">
        @foreach ($cs as $c )
        <div class="col-md-3 mt-3">
            <div class="card text-center">
                <a href="{{ route('user-categories',['category' => $c->value]) }}" class="p-3 btn-website font-bold" style="font-weight: bold">
                    {{ $c->name }}
                </a>
            </div>
        </div>
        @endforeach

    </div>
</div>
@endif


@if (isset($post) && $post)
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-end">
                <a href="{{route('all_public_posts')}}" class="btn btn-lg btn-website">All Posts </a>
            </div>
        </div>
        <div class="col-md-8 offset-md-2">
            <h2 class="my-2"> Recent Post </h2>
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <img src="{{asset('storage/'.$post->upload_img)}}" alt="{{$post->f_name ?? '' }}"
                        class="img-fluid" />
                </div>
            </div>
            <h3 class="text-center mt-2 text-uppercase">
                {{ $post->title }}
            </h3>
            <div class="mt-2">
                {!! reduceWithStripping($post->message,300) !!}
            </div>
            <a href="{{route('public_posts',['slug' => $post->slug])}}" class="btn btn-primary my-2 float-right"> Read
                More </a>
        </div>
    </div>
</div>
@endif

<div class="container-fluid">
    <div class="jumbotron bg-website text-white my-2 text-center">
        <h2>
            Become An Instructor

        </h2>
        <div class="my-1">
            Spread your knowledge to millions of students around the world through teachify teaching platform.
            You can teach any tech you love from heart
        </div>
        <a href="{{route('dashboard')}}" class="btn btn-website border">
            Start Teaching Now
        </a>
    </div>
</div>
@if (isset($faq) && $faq)
<div class="container-fluid my-3">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-end">
                <a href="{{route('public_faq')}}" class="btn btn-lg btn-website">All FAQ </a>
            </div>
        </div>
        <div class="col-md-8 offset-md-2">
            <h2 class="my-2"> Recent FAQ </h2>
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <img src="{{asset('storage/'.$faq->upload_img)}}" alt="{{$faq->f_name ?? '' }}" class="img-fluid" />
                </div>
            </div>
            <h3 class="text-center mt-2 text-uppercase">
                {{ $faq->title }}
            </h3>
            <div class="mt-2">
                {!! reduceWithStripping($faq->message,300) !!}
            </div>
            <a href="{{route('public_faqs',['slug' => $faq->slug])}}" class="btn btn-primary my-2 float-right"> Read
                More </a>
        </div>
    </div>
</div>
@endif
@endsection


@section('script')
{{-- <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
  </script> --}}

@endsection