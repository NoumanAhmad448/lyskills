@extends('layouts.guest')

@section('content')
<div class="container-fluid my-5">
    <h1> All Courses</h1>
    @if ($courses && $courses->count())
    <div class="row mt-2">
        @foreach ($courses as $course)
        @php $ci = $course->course_image; @endphp
        <div class="col-md-3 mt-2">
            @if($course->slug)
            <div class="card" style="width: 18rem;">
                <a href="{{route('user-course', ['slug' => $course->slug])}}">
                    @if($ci) <img class="card-img-top img-fluid" src="{{ asset('storage/'.$ci->image_path)}}"
                        alt="{{ $ci->image_name }}"> @endif
                </a>
                <div class="card-body">
                    <h5 class="card-title font-bold text-capitalize"> {{ $course->course_title ?? ''}} </h5>
                    <p class="card-text text-capitalize mt-1"> By <span class="font-bold">
                            {{ $course->user->name ?? '' }} </span> </p>
                    <p class="card-text text-capitalize mt-1"> Category {{ $course->categories_selection ?? '' }} </p>
                    <p class="card-text text-capitalize mt-1"> @if($course->price->is_free) {{ __('free') }} @else $
                        {{ $course->price->pricing ?? '' }} @endif </p>
                </div>
            </div>
            @endif
        </div>
        @endforeach
       

    </div>
    <div class="d-flex justify-content-end">
        {{$courses->links()}}
    </div>
    @else
        <div class="jumbotron bg-website text-white text-center">
            <h3> No Course Found </h3>
            <div> Currently there is no course available here. please come here again to check your favorite course <div>
        </div>
    @endif
</div>
@endsection