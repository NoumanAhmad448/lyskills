@include('courses.dashboard_header')
@php 
$course_id = $course->id;
@endphp


<div class="container-fluid" >
    <div class="row">
        <div class="d-md-none icon-sm ml-3 mt-3 mt-md- 0 ml-md-0" id="hamburger"><i class="las la-bars"></i></div>
        <div class="col-md-3 p-3 p-md-5 d-none d-md-block" id="side_menu">
            <h5> Plan your Course </h5>
            
            <ul class="nav flex-column text-info">
                <li class="nav-item">
                    <a class="nav-link text-info" href="{{route('landing_page',compact('course'))}}" id="landing_page"> <i class="las la-pager"></i> Landing Page </a>                
                </li>
                <li class="nav-item">
                    <a class="nav-link text-info" href="{{route('courses_dashboard',compact('course_id'))}}"
                     id="target_students"><i class="las la-lightbulb"></i> Target Student Details</a>                
                </li>
                <li class="nav-item">
                    <a class="nav-link text-info" 
                    href="{{route('courses_curriculum',compact('course_id'))}}" id="courses_curriculum">
                     <i class="las la-cloud-upload-alt"></i> Course Curriculum  </a>                
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link text-info" href="{{route('course_structure',compact('course_id'))}}" 
                    id="course_structure"><i class="las la-star"></i> Course Structure</a>                
                </li>
                <li class="nav-item">
                    <a class="nav-link text-info" href="{{route('course_setup',compact('course_id'))}}" id="course_setup"><i class="las la-radiation"></i> Course Setup</a>                 --}}
                </li>
            </ul>
           {{-- <section class="mt-4">
                <h5> 
                    Create your content
                </h5> --}}
                
                {{-- <ul class="nav flex-column text-info"> --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link text-info" href="{{route('courses_film_edit',compact('course_id'))}}" id="film_edit"> <i class="las la-film"></i> Film & edit </a>                
                    </li> --}}
                   
                    
                {{-- </ul>
           </section> --}}
           <section class="mt-4">
                <h5> 
                    Last Step
                </h5>
                
                <ul class="nav flex-column text-info">
                   
                    <li class="nav-item">
                <a class="nav-link text-info" href="{{route('pricing',compact('course'))}}" id="pricing"> <i class="lab la-cc-visa"></i> Course Pricing </a>                
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-info" href="{{route('promotion',compact('course'))}}" id="promotion"> <i class="las la-film"></i> {{ __('Coupon') }} </a>                
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-info" href="{{route('zaijian',compact('course'))}}" id="msg"> <i class="las la-bullhorn"></i> Messages </a>                
                    </li>
                </ul>
                @if(isset($course) && $course && $course->status != "published")
                    <div id="sub_course" class="btn btn-info btn-md-lg mt-5" link="{{route('submitCourse',compact('course'))}}" > <i class="las la-database"></i> Submit for Review </div>                
                @endif
           </section>
        </div>

        @yield('content')

    </div>
</div>


@include('courses.dashboard_footer')
