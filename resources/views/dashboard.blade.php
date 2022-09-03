@php
use App\Models\CourseStatus;
use App\Models\CourseEnrollment;
use App\Models\InstructorEarning;
use Carbon\Carbon;
@endphp
{{-- <x-app-layout>     --}}
    @extends('layouts.dashboard_header')
    @section('page-css')        
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    @endsection
    @section('header')
        <h2>
            {{ __('Instructor Dashboard') }}
        </h2>
    @endsection



    @section('content')
       @if (isset($ann) && $ann->count())
       <div class="container-fluid mt-5 text-center font-bold">           
           @foreach ($ann as $a)            
                <div style="font-weight: bold"class="alert alert-warning alert-dismissible fade show" role="alert"> {{ $a->message ?? '' }} 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                </div>               
           @endforeach    
           {{ $ann->links() }}
        </div>
       @endif
       
        <div class="container-fluid my-2">
            <div class="d-flex justify-content-end">                
                <div class="form-inline">
                    <form action="{{route('create_course')}}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-lg create_course" 
                            data-toggle="tooltip" data-placement="top" title="Create Course"

                        > New Course </button>
                    </form>
                </div>
            </div>
        </div>
       
        @include('session_msg')
       
        <div class="container-fluid">
            @foreach ($courses as $course)
                <div class="row p-3 mt-3 border mb-2">
                    
                    <div class="col-md-12">
                        <div class="row">
                        <div class="col-md-2">
                            @php $course_img = $course->course_image @endphp
                            
                            @if($course_img)
                            @if($course->slug)
                                <a href="{{ route('user-course', ['slug' => $course->slug ]) }}" target="_blank" class="text-dark">
                            @endif
                                <img src="{{asset('storage/'.$course_img->image_path)}}" alt="{{$course_img->image_name}}" width="150" class="img-fluid img-thumbnail" />
                            @if($course->slug)
                                </a>
                            @endif                            
                            @endif
                        </div>
                        <div class="col-md-3 d-flex align-items-center">                            
                            
                            <h4 class="text-capitalize"> 
                                @if($course->slug)
                                    <a href="{{ route('user-course', ['slug' => $course->slug ]) }}" target="_blank" class="text-dark" style="font-size: 1.2rem">
                                @endif
                                @php $course_title = $course->course_title; 
                                    // if($course_title && strlen($course_title) > 20){
                                    //   echo substr($course_title , 0, 20) . '...';   
                                    // }else 
                                    if($course_title){
                                        echo $course_title;
                                    }else{
                                        echo "No title";
                                    } 
                                    $course_id = $course->id; 
                                @endphp
                                @if($course->slug)
                                    </a>
                                @endif
                                <div style="font-size: 0.9rem" class="mt-2 "> <a target="_blank" href="{{route('laoshi_de_c',['course'=>$course->id])}}" class="text-primary">Comments</a></div>
                            </h4> 
                        </div>
                        <div class="col-md-1 d-flex align-items-center ">                            
                            @php
                                $status = $course->status;
                                @endphp
                            <div class="badge @if($status == "draft") {{ __('badge-warning') }} 
                                    @elseif($status == 'published') {{ __('badge-success')}}
                                    @elseif($status == 'unpublished') {{ __('badge-danger')}}
                                    @elseif($status == 'pending') {{ __('badge-info')}} 
                                    @elseif($status == 'block') {{ __('badge-danger')}} 
                                    @endif"> {{ $status ?? '' }} </div>
                        </div>
                        
                        <div class="col-md-3 d-flex align-items-center">                            
                            <a class="mt-2 ml-0 ml-md-3 btn btn-primary edit" href="{{route('landing_page',['course' => $course_id])}}"
                                data-toggle="tooltip" data-placement="top" title="Edit Course"
                                > <i class="las la-pen"></i> Edit </a>                       
                            <form action="{{route('course_delete',['course_id' => $course_id ])}}" method="post" class="course_delete_form f_{{$course_id}}"> 
                                @csrf
                                @method('delete')
        
                                <a class="mt-2 ml-3 btn btn-danger delete_course" id="f_{{$course_id}}"
                                data-toggle="tooltip" data-placement="top" title="Delete Course"
                                ><i class="las la-trash-alt"></i> Delete </a>                                           
                            </form>
                        </div>
                        
                        @if($course->status == "draft")
                            <div class="col-md-2 mt-4 pt-3">
                                @php 
                                    $c_status = CourseStatus::where('course_id',$course->id)->first();
                                    if(isset($c_status)){

                                        $progress = 0;
                                        $progress = 
                                    (int)$c_status->target_ur_students + 
                                    (int)$c_status->curriculum + 
                                    (int)$c_status->landing_page +
                                    (int)$c_status->pricing + 
                                    (int)$c_status->message +
                                    (int)$c_status->course_img +
                                    (int)$c_status->course_video;
                                    
                                }
                                @endphp
                                @if($progress)
                                    <div class="progress">
                                        <div class="progress-bar @if($progress != 100) {{ __('progress-bar-striped')}} @endif  progress-bar-animated
                                         @if($progress == 100) {{ __('bg-info')}} @endif" role="progressbar" 
                                            aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100" 
                                            style="width: {{$progress}}%"> {{$progress}}%
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @elseif($course->status == "pending")
                            <div class="col-md-3 d-flex justify-content-center align-items-center flex-column">
                                Submitted at : {{ $course->updated_at  }}
                            </div>
                        @else
                            <div class="col-md-3 d-flex justify-content-center align-items-center flex-column">
                                @php 
                                    $m_en =  CourseEnrollment::where('course_id',$course->id)->whereMonth('created_at',
                                    Carbon::now()->month)->
                                    whereYear('created_at', Carbon::now()->year)->count();
                                    $m_ear = InstructorEarning::where('course_id',$course->id)->
                                    whereMonth('created_at',
                                    Carbon::now()->month)->
                                    whereYear('created_at', Carbon::now()->year)->sum('earning');
                                    
                                @endphp
                                @if($m_en) <div class="text-success"> This month Enrollment {{$m_en}} </div> @endif
                                @if($m_ear) <div class="text-success"> This month Income ${{$m_ear}} </div> @endif
                            </div>
                        @endif
                    </div>
                        
                    </div>
                    
                </div>
            @endforeach
            <div class="container mb-3">
                {{ $courses->links() }}
            </div>



            {{-- course delete modal  --}}
            <div class="modal" tabindex="-1" id="course_delete">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header bg-static-website">
                      <h5 class="modal-title font-weight-bold">Delete the Course?</h5>
                      <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body ">                     
                      <div> You ara about to delete the course.Deleting it will delete all the videos, quizzes, assignment and 
                          all other content from the website.
                      </div>
                      <div class="text-danger">
                          If we find any student enrolled in your course, you will not be able to delete it because we
                          promise our students to provide them course content for life time.
                      </div>
                      
                       <hr>
                    <div > For more information, Please check our <a href=""> Policy </a> </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="las la-times"></i> Cancel </button>                    
                      <button type="button" class="btn btn-danger delete" > <i class="las la-trash-alt"></i> Delete </button>
                    </div>
                  </div>
                </div>
              </div>


        </div>
    @endsection


    @section('page-js')  

        <script src="{{asset('js/dashboard.js')}}">                        
        </script>
        <script>
            $(function(){
                $('.edit, .delete_course, .create_course').tooltip();
            });
        </script>
    @endsection
{{-- </x-app-layout> --}}
