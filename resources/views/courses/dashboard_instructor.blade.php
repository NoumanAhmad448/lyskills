@extends('courses.dashboard_main')
@php

$learable_skill     = json_decode($course->learnable_skill); 
$course_requirement = json_decode($course->course_requirement);
$targeting_students = json_decode($course->targeting_student);

@endphp
@section('page-css')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('content')

    <div class="col-12 col-md-9 bg-white border border-light p-3">
        

        <h1 class="my-3"> Target Student Details </h1>
        <hr>
        <p class="my-4">
            Students Learning Objectives
        </p>

        <section id="learnable_skills_sec">
            <label for="learnable_skills">What will students learn in your course?</label>

            <div class="d-none alert alert-danger" id="learnable_skills_err"> </div>

            @if ($learable_skill)
            @foreach ($learable_skill as $ls)                    
                    <div class="input-group input-group-lg my-2">
                        <input type="text" class="form-control learnable_skills" 
                            placeholder="example: about the design of wordpress"
                            value="{{ $ls }}">

                        <span class="input-group-text btn btn-danger" onclick="removeParent(event)"><i
                                class="las la-trash-alt"></i></span>
                        <span class="input-group-text"> <i class="las la-arrows-alt"></i></span>
                    </div>
                @endforeach
            @else
                <div class="input-group input-group-lg my-2">
                    <input type="text" class="form-control learnable_skills" 
                        placeholder="example: about the design of wordpress">

                    <span class="input-group-text btn btn-danger" onclick="removeParent(event)"><i
                            class="las la-trash-alt"></i></span>
                    <span class="input-group-text"> <i class="las la-arrows-alt"></i></span>
                </div>
            @endif
        </section>
        <div class="learn_errs"> </div>
        <div>
            <div href="#" class="my-2 btn website-outline" id="learnable_skills_btn"> <i class="las la-plus"></i> Add
                Answer </div>
        </div>

        <section id="course_requirement_sec">
            <label for="course_requirement" class="mt-5">Course Requirements and Prerequisite</label>
            <div class="d-none alert alert-danger" id="course_requirement_err"> </div>
            @if ($course_requirement)
                @foreach ($course_requirement as $cr)
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control course_requirement" 
                            placeholder="example: wordpress designing must be experienced before a bit" value="{{ $cr }}">
                        <span class="input-group-text btn btn-danger" onclick="removeParent(event)"><i
                                class="las la-trash-alt"></i></span>
                        <span class="input-group-text"> <i class="las la-arrows-alt"></i></span>

                    </div>
                @endforeach
            @else
                <div class="input-group input-group-lg">
                    <input type="text" class="form-control course_requirement" 
                        placeholder="example: wordpress designing must be experienced before a bit">
                    <span class="input-group-text btn btn-danger" onclick="removeParent(event)"><i
                            class="las la-trash-alt"></i></span>
                    <span class="input-group-text"> <i class="las la-arrows-alt"></i></span>

                </div>
            @endif

        </section>
        <div class="re_errs"> </div>
        <div>
            <div class="my-2 btn website-outline" id="course_requirement_btn"> <i class="las la-plus"></i> Add answer
            </div>
        </div>
        <section id="targeting_students_sec">
            <label for="targeting_students" class="mt-5"> Who are target Audience</label>
            <div class="alert alert-danger d-none" id="targeting_students_err"> </div>

            @if ($targeting_students)
                @foreach ($targeting_students as $ts)
                    <div class="input-group input-group-lg ui-state-default">
                        <input type="text" class="form-control targeting_students" 
                            placeholder="Example: Beginner Python developers curious about data science" value="{{$ts}}">
                        <span class="input-group-text btn btn-danger" onclick="removeParent(event)"><i
                                class="las la-trash-alt"></i></span>
                        <span class="input-group-text"> <i class="las la-arrows-alt"></i></span>

                    </div>
                @endforeach
            @else
                <div class="input-group input-group-lg ui-state-default">
                    <input type="text" class="form-control targeting_students" 
                        placeholder="Example: Beginner Python developers curious about data science">
                    <span class="input-group-text btn btn-danger" onclick="removeParent(event)"><i
                            class="las la-trash-alt"></i></span>
                    <span class="input-group-text"> <i class="las la-arrows-alt"></i> </i></span>

                </div>
            @endif


        </section>
        <div class="target_errs"> </div>
        <div class="mb-5">
            <div class="my-2 btn website-outline" id="targeting_students_btn"> <i class="las la-plus"></i> Add answer
            </div>
        </div>
        <input type="hidden" id="myurl" url="{{ url('course/' . $course_id . '/manage/goals') }}"  />        
        
        <button type="button" class="btn btn-lg btn-info" disabled id="save_btn"> <i class="las la-save"></i> Save </button>

    </div>
 </div>
@endsection



@section('page-js')
    <script src="{{asset('js/target_ur_students.js')}}" >
    </script>
    <script>
        function removeParent(event) {
            $(event.target).parents('.input-group').first().remove();
        }  
     </script>
    <script>

        $(document).ready(function() {          

            $("#save_btn, .save_btn").click(function() {
                let learnable_skills = [];
                $(".learnable_skills").each(function() {
                    let val = $(this).val();
                    if (val !== "") {
                        learnable_skills.push(val);
                    }
                });


                let course_requirements = [];
                $(".course_requirement").each(function() {
                    let val = $(this).val();
                    if (val !== "") {
                        course_requirements.push(val);
                    }
                });

                let targeting_students = [];
                $(".targeting_students").each(function() {
                    let val = $(this).val();
                    if (val !== "") {
                        targeting_students.push(val);
                    }
                });
                
                var myurl = $('#myurl').attr('url');
                var l_errs = $('.learn_errs');
                var re_errs = $('.re_errs');
                var target_errs = $('.target_errs');
                


                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: myurl,
                    type: 'POST',
                    data: {
                        learnable_skill: learnable_skills,
                        course_requirement: course_requirements,
                        targeting_student: targeting_students,
                        course_id: {{
                                $course_id                         
                        }}
                    },
                    dataType: 'JSON',
                    success: function(message) {
                        alert(message['status']);
                    },
                    error: function(data){
                        let errors = JSON.parse(data.responseText)['errors'];
                        if("learnable_skill" in errors){
                            l_errs.addClass("text-danger").text(errors['learnable_skill'][0]);
                        }else if("course_requirement" in errors){
                            re_errs.addClass("text-danger").text(errors['course_requirement'][0]);
                        }else if ("targeting_student" in errors){
                            target_errs.addClass("text-danger").text(errors['targeting_student'][0]);
                        }else{
                            alert('There is an error while saving your data');
                        }
                        setTimeout(() => {
                            l_errs.removeClass('text-danger').text('');
                            re_errs.removeClass('text-danger').text('');
                            target_errs.removeClass('text-danger').text('');
                        }, 10000);
                    }
                });

            });
                        
        });
       
    </script>

@endsection