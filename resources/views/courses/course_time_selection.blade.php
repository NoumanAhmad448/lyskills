@extends('courses.course_header')

@section('course_content')
    

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="d-flex flex-row justify-content-between my-4">
                <section class="d-flex">
                    <a class="mr-1" href="http://127.0.0.1:8000/dashboard"> Lyskills </a>
                    <div> Step 4 of 4 </div>
                </section>
                <a href="http://127.0.0.1:8000/dashboard" class="mr-3"> Exit </a>

            </div>
            <div class="progress" style="height: 1px;">
                <div class="progress-bar w-100" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row jumbotron">
        <div class="col-md-8 offset-md-2">     
             
                <div class="">
                    <h1 class="text-center">
                        How much time can you spend creating your course per week?
                    </h1>

                    <p class="text-center">
                        There's no wrong answer. We can help you achieve your goals even if you don't have much time.
                    </p>
                    <form id="nextform" action="{{route("courses_instructions",['id'=>$id+1, 'course_id' => $course_id])}}" method="POST" class="mt-5">
                       @csrf

                        <section class="d-flex flex-column">

                            <div class="form-check border border-secondary pl-5 py-3 option">
                                <input class="form-check-input" type="radio" name="time_selection" id="time_selection1" value="option1">
                                <label class="form-check-label" for="time_selection1">
                                    I’m very busy right now (0-2 hours)
                                </label>
                            </div>
                            <div class="form-check border border-secondary pl-5 py-3 option mt-2">
                                <input class="form-check-input" type="radio" name="time_selection" id="time_selection2" value="option2">
                                <label class="form-check-label" for="time_selection2">
                                    I’ll work on this on the side (2-4 hours)
                                </label>
                            </div>
                            <div class="form-check border border-secondary pl-5 py-3 option mt-2">
                                    
                                <input class="form-check-input" type="radio" name="time_selection" id="time_selection3" value="option3">
                                <label class="form-check-label" for="time_selection3">
                                    I have lots of flexibility (5+ hours)
                                </label>
                            </div>
                            <div class="form-check border border-secondary pl-5 py-3 option mt-2">
                                <input class="form-check-input" type="radio" name="time_selection" id="time_selection4" value="option4">
                                <label class="form-check-label" for="time_selection4">
                                    I haven’t yet decided if I have time
                                </label>
                            </div>

                            <div> 
                        </div>
                        </section>
                       
                    </form>
                </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-2">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                
                 <div>  
                    <a href="{{route("courses_instructions",['id'=>$id-1, 'course_id' => $course_id])}}" class="btn btn-primary btn-lg"> 
                        Previous
                    </a>
                </div>
                               

                <button type="submit" class="btn btn-primary btn-lg next" disabled="" form="nextform"> 
                    Create Course 
                </button>
        


            </div>

        </div>

    </div>
</div>

@endsection

@section('course_footer')
    <script src="{{asset('js/course_time_selection.js')}}">
    </script>
@endsection
