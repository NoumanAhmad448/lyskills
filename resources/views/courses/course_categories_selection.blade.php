@extends('courses.course_header')
@section('course_css')
@endsection


@section('course_content')
    

@php 
use App\Models\Course;
$course = Course::where('id',$course_id)->where('user_id',Auth::id())->first();
if(!$course){
    abort(404);
}
$course_category = $course->categories_selection;



@endphp

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="d-flex flex-row justify-content-between my-3">
                <section class="d-flex">
                    <a class="mr-1" href="{{ route('dashboard') }}"> Lyskills </a>
                    <div> Step 2 of 2 </div>
                </section>
                <a href="{{ route('dashboard') }}" class="mr-3"> Exit </a>

            </div>
            <div class="progress" style="height: 1px;">
                <div class="progress-bar w-50"
                    role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row jumbotron mb-0">
        <div class="col-md-8 offset-md-2 jumbotron mb-0">     
             
                <div class="jumbotron text-center">
                    <h1>
                        What category best fits the knowledge you'll share?
                    </h1>
                    <p>
                        If you're not sure about the right category, you can change it later.
                    </p>
                    <form id="nextform" action="{{route('courses_instructions',['id' => $id+1 , 'course_id' => $course_id])}}" method="POST">
                        @csrf
                        
                        <select class="custom-select categories" name="categories_selection">
                            @if($categories->count())
                                <option @if(!$course_category) {{ __('selected') }} @endif value="Choose a category">  Choose a category </option>
                                @foreach ($categories as $c)
                                    @php $value = $c->value; @endphp
                                  <option @if($course_category == $value) {{ __('selected') }} @endif value="{{$value ?? null}}"> {{$c->name ?? null}} </option>
                                @endforeach
                            @endif
                        </select>
                    </form>
                </div>
               
        </div>
    </div>
</div>

<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                
                 <div>  
                    <a href="{{route('courses_instructions',['id' => $id-1 , 'course_id' => $course_id])}}" class="btn btn-primary btn-lg px-4"> 
                        Previous
                    </a>
                </div>
                               

                {{-- <button type="submit" class="btn btn-primary btn-lg next px-5" disabled="" form="nextform"> 
                    Next
                </button> --}}
                <button type="submit" class="btn btn-primary btn-lg next" disabled="" form="nextform"> 
                    Create Course 
                </button>


            </div>

        </div>

    </div>
</div>

@endsection

@section('course_footer')
    <script src="{{asset('js/course_category.js')}}">        
    </script>
    
@endsection