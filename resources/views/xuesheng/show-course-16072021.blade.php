@extends('layouts.guest')


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
                                @if($ci) <img class="card-img-top" src="{{ asset('storage/'.$ci->image_path)}}" alt="{{ $ci->image_name }}"> @endif
                            </a>
                        </div>
                        <div class="col-md-9 p-3">
                            <h3 class="card-title font-bold text-capitalize"><a href="{{route('user-course', ['slug' => $course->slug])}}">
                                 {{ $course->course_title ?? ''}} </h3>
                            </a>
                            <p class="card-text text-capitalize mt-1"> By <span class="font-bold"> {{ $course->user->name ?? '' }} </span> </p>
                            <p class="card-text text-capitalize mt-1"> Category {{ $course->categories_selection ?? '' }} </p>                            
                            <p class="card-text text-capitalize mt-1"> @if($course->price->is_free)  {{ __('free') }} 
                                @else ${{ $course->price->pricing ?? '' }}   @endif </p>                    
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