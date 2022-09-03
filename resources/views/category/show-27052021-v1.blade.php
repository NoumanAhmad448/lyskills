

@extends('layouts.guest')


@section('content') 
    <div class="jumbotron bg-website text-white text-center">
        <h1> {{ $c->name ?? ''}} </h1>
    </div>
    @if (isset($courses) && $courses->count())
    <div class="container">
        <div class="row">
        @foreach ($courses as $course)            
            @php $ci = $course->course_image; @endphp
            <div  class="col-md-3 my-5">
                @if($course->slug)
                <div class="card w-100" style="height: 28rem">
                    <a href="{{route('user-course', ['slug' => $course->slug])}}">
                        @if($ci) <img class="card-img-top" src="{{ asset('storage/'.$ci->image_path)}}" alt="{{ $ci->image_name }}"> @endif
                    </a>
                        <div class="card-body">
                            <h5 class="card-title font-bold text-capitalize"> {{ $course->course_title ?? ''}} </h5>
                            <p class="card-text text-capitalize mt-1 mb-0"><span class=""> {{ $course->user->name ?? '' }} </span> </p>
                            <p class="card-text text-capitalize mt-1 mb-0"> Category {{ $course->categories_selection ?? '' }} </p>                            
                            <p class="card-text text-capitalize mt-1 mb-0 d-flex font-bold"> @if($course->price->is_free)  {{ __('free') }} @else 
                                {{ $course->price->pricing ?? '' }}  
                                @php $total_p = ((int)$course->price->pricing)+20 @endphp
                                <del class="ml-2"> ${{ $total_p }} </del> @endif </p>                    
                        </div>
                    </div>
                    @endif
            </div>
        @endforeach

        </div>    
        <div class="d-flex justify-content-end my-4">
            {{ $courses->links() }}
        </div>
    </div>
    @else 
        <section class="d-flex justify-content-center flex-column align-items-center">
            <img src="{{asset('img/record.jpg')}}" alt="record" class="img-fluid w-50"/>
            <div class="display-3"> No Course Found </div>
        </section>    
    @endif

@endsection