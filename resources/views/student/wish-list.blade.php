<?php 
use App\Models\Course;
?>

@extends('layouts.guest')

@section('content')
    <div class="container mt-4" style="min-height: 100vh">
        <h1> WishList Courses </h1>
        @if($courses->count())
        <div class="row">
            @foreach ($courses as $c)            
                @php $course = Course::where('id',$c->c_id)->first(); 
                    if(!$course){
                        continue;
                    }
                $ci = $course->course_image; @endphp

                
                <div  class="col-md-3 my-5">
                    @if($course->slug)
                    <div class="card" style="width: 18rem;">
                        <a href="{{route('user-course', ['slug' => $course->slug])}}">
                            @if($ci) <img class="card-img-top" src="{{ asset('config('setting.s3Url').$ci->image_path}}" alt="{{ $ci->image_name }}"> @endif
                        </a>
                            <div class="card-body">
                                <h5 class="card-title font-bold text-capitalize"> {{ $course->course_title ?? ''}} </h5>
                                <p class="card-text text-capitalize mt-1"> By <span class="font-bold"> {{ $course->user->name ?? '' }} </span> </p>
                                <p class="card-text text-capitalize mt-1"> Category {{ $course->categories_selection ?? '' }} </p>                            
                                <p class="card-text text-capitalize mt-1"> @if($course->price->is_free)  {{ __('free') }} @else {{ $course->price->pricing ?? '' }} @endif </p>                    
                            </div>
                            <form action="{{route('remove-wishlist-course',['slug' => $course->slug])}}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger w-100"> Remove From Wishlist </button>
                            </form>
                        </div>
                        @endif
                </div>
                @endforeach
            </div>

             <div class="d-flex justify-content-end">
                 {{ $courses->links()}}
             </div>
        @else
        <div class="jumbotron text-center bg-website text-white my-5">
            <h3 class="text-center"> WishList Courses </h3>
            <div> You did not mark any course as wishlist. To add course in your wishlist, visit 
                course page and click wishlist button. 
            </div>
            <a href="{{route('index')}}" class="mt-3 btn btn-website"> Home Page </a>
        </div>
        @endif
    </div>
@endsection