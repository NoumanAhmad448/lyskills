<?php 
use App\Models\RatingModal;

?>
@extends('layouts.guest')
@section('page-css')
{{-- <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" /> --}}
    <style>
        /* fix-height */
        @media all and (min-width: 576px) {
            .fix-height{
                height: 26rem !important;
            }
        }
        .fix-height{
                height: 24rem !important;
        }
    </style>
@endsection

@section('content')
    <div class="container my-5">
        <h1 class="text-capitalize"> {{$keyword ?? 'Courses' }} </h1>       
        @if ($courses->count())
            @foreach ($courses as $course)  
                <div class="row my-3 border">
                    @if($course->slug)
                        <div class="col-md-3">
                            @php $ci = $course->course_image; @endphp
                            <a href="{{route('user-course', ['slug' => $course->slug])}}">
                                @if($ci) <img class="card-img-top" src="{{ config('setting.s3Url').$ci->image_path}}" alt="{{ $ci->image_name }}"> @endif
                            </a>
                        </div>
                        <div class="col-md-9 p-3">
                            {{-- <h3 class="card-title font-bold text-capitalize"><a href="{{route('user-course', ['slug' => $course->slug])}}">
                                 {{ $course->course_title ?? ''}} </h3>
                            </a>
                            <p class="card-text text-capitalize mt-1"> By <span class="font-bold"> @if($course->user){{ $course->user->name ?? '' }}@endif </span> </p>
                            <p class="card-text text-capitalize mt-1"> Category {{ $course->categories_selection ?? '' }} </p>
                            <p class="card-text text-capitalize mt-1"> @if($course->price->is_free)  {{ __('free') }}
                                @else ${{ $course->price->pricing ?? '' }}   @endif </p>                     --}}
                            @php
                                $rating_avg = (float) RatingModal::where('course_id',$course->id)->avg('rating');
                                $rated_by_students = (int) RatingModal::where('course_id',$course->id)->count('rating');
                            @endphp
                              <div class="card-body" style="height: 150px">
                                <h5 class="card-title font-bold text-capitalize" style="font-size: 1.1rem;font-weight:bold"> {{ reduceCharIfAv($course->course_title ?? '', 40)}} </h5>
                                <p class="card-text text-capitalize mb-0 mt-1"><span class=""> @if(!empty($course->user)){{ reduceWithStripping($course->user->name,20) ?? '' }}@endif </span>
                                </p>
                                <p class="mb-0 mt-1 @if($course->categories_selection == 'it') {{ 'text-uppercase' }} @else {{ 'text-capitalize'}} @endif">  {{ reduceWithStripping($course->categories_selection,20) ?? '' }} </p>
                                @if($rating_avg)
                                <div class="d-flex align-items-center">
                                    <section id="rating" class="d-flex align-items-center" style="cursor: pointer">
                                    ({{round($rating_avg,2)}})
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

           
            <div class="d-flex-justify-content-end">
                {{ $courses->links() }}
            </div>
        @else 
            <section class="d-flex justify-content-center flex-column align-items-center">
                <img src="{{asset('img/record.jpg')}}" alt="record" class="img-fluid w-50"/>
                <div class="display-3"> No Course Found </div>
            </section>  
        @endif
    </div>

@endsection