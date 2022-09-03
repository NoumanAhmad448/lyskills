@extends('courses.course_header')
@section('course_css')
   <style type="stylesheet" href="{{asset('css/course_instruction.css')}}"></style>
@endsection

@section('course_content')
    
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="d-flex flex-row justify-content-between my-4">
                <section class="d-flex">
                    <a class="mr-1" href="{{route('dashboard')}}"> Lyskills </a>
                    <div> Step 1 of 4 </div>
                </section>
                <a href="{{route('dashboard')}}" class="mr-2"> Exit </a>

            </div>
            <div class="progress" style="height: 1px;">
                <div class="progress-bar w-25" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row jumbotron">
        <div class="col-md-8 offset-md-2">
            
                <div class="text-center">
                    <h1>
                        First, let's find out what type of course you're making.
                    </h1>
                    
                    <section class="row">
                        <div class="col-md-4 offset-md-2 bg-white">
                            <div>
                                <div class=" p1  jumbotron bg-white @if($course_type === 'course') {{__('text-primary')}}@endif" >
                                    <i class="las la-file-video"></i>
                                    <h5 class="card-title">Course</h5>
                                    <p class="card-text">
                                        Create rich learning experiences with the help of video lectures, quizzes,
                                        coding exercises, etc.
                                    </p>
                                    <div class="form-check">
                                        <input type="radio" hidden="" name="course">
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 bg-white ml-md-3">
                            <div class="">

                                <div class="p2 jumbotron bg-white @if($course_type === 'practice') {{__('text-primary')}}@endif">
                                    <i class="las la-notes-medical"></i>
                                    <h5 class="card-title">Practice Test </h5>
                                    <p class="card-text">Help students prepare for certification exams by providing
                                        practice
                                        questions.
                                    </p>
                                   
                                </div>
                            </div>
                        </div> 
                    </section>
                </div>           
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm">
            <div class="d-flex justify-content-end">
                
                <form action="{{ route('courses_instructions', ['id' => $id, 'course_id' => $course_id])  }}" method="POST">
                    @csrf
                    <div class="form-check">
                        <input type="hidden" value="@if($course_type === 'practice'){{__('practice')}}@endif" name="practice" id="practice">
                    </div>
                    
                    <div class="form-check">
                        <input type="hidden" value="@if($course_type === 'course'){{__('course')}}@endif" name="course" id="course">
                    </div>

                    <button id="nextbtn" type="submit" class="btn btn-primary btn-lg next"
                        @if(!$course_type) {{ __('disabled')}} @endif> 
                        Next
                    </button>
                </form>


                
            </div>

        </div>

    </div>
</div>

@endsection

@section('course_footer')
    <script src="{{asset('js/course_instruction.js')}}">
    
    </script>

@endsection
