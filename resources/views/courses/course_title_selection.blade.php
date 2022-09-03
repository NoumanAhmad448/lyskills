@extends('courses.course_header')
@section('course_css')
@endsection


@section('course_content')
    

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="d-flex flex-row justify-content-between my-3">
                <section class="d-flex">
                    <a class="mr-1" href="{{route('dashboard')}}"> Lyskills </a>
                    <div> Step 1 of 2 </div>
                </section>
                <a href="{{route('dashboard')}}" class="mr-3"> Exit </a>

            </div>
            <div class="progress" style="height: 1px;">
                <div class="progress-bar w-50" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row jumbotron mb-0">
        <div class="col-md-8 offset-md-2 jumbotron mb-0">
           
             
                <div class="jumbotron text-center">
                    <h1>
                        How about a working title?
                    </h1>
                    <p>
                        It's ok if you can't think of a good title now. You can change it later.
                    </p>
                    <form id="nextbtn" action="{{route('courses_instructions',['id' => $id+1, 'course_id' => $course_id])}}" method="POST">
                        @csrf
                        
                        <div class="input-group mb-3">
                            
                            <input maxlength="60" type="text" class="form-control" placeholder="e.g. wordpress training" required="" name="course_title" value="{{$course_title}}" id="title_box">
                            
                            
                                <div class="input-group-append">
                                <span class="input-group-text" id="title">60</span>
                            </div>
                        </div>
                        
                                                
                    </form>
                    
                    <span class="invisible count_char"> 1 </span>

                    
                </div>
            
            
               
        </div>
    </div>
</div>

<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-end">
                
                {{-- <div>  
                    <a href="{{route('courses_instructions',['id' => $id-1, 'course_id' => $course_id])}}" class="btn btn-primary btn-lg px-4"> 
                        Previous
                    </a>
                </div> --}}
                
                      
               
                <button type="submit" form="nextbtn" class="btn btn-primary btn-lg next px-5">
                    Next
                </button>
            


            </div>

        </div>

    </div>
</div>

@endsection


@section('course_footer')
    <script src="{{asset('js/course_title.js')}}">
    </script>
@endsection


