@extends('courses.dashboard_main')
@section('content')
    <div class="col-md-9 bg-white mt-2 mt-md-3">
        <h1 class="mt-2"> Course structure </h1>
        <div class="container-fluid bg-light">
            <div class="row">
                <div class="col-md-8 mt-md-3 jumbotron text-center">
                    <h2 class="mt-3 mt-md-5">
                        There's a course in you. Plan it out.
                    </h2>
                    <p class="mt-3">
                        Planning your course carefully will create a clear learning path for students and help you once you film. Think down to the details of each lecture including the skill you’ll teach, estimated video length, practical activities to include, and how you’ll create introductions and summaries.
    
                    </p>
                    
                </div>
                <div class="col-md-4">
                    <div class="jumbotron  bg-website  mt-md-3 text-center">
                        <span class="mt-md-2 icon-large"><i class="lab la-readme"></i></span>
                        <h5 class="mt-2">
                            Our library of resources
                        </h5>
                        <p >
                            Tips and guides to structuring a course students love
                        </p>
                        <a href="" class="btn website-outline btn-lg"> teach on lyskills </a>

                    </div>
                </div>
            </div>
        </div>

        <section class="tips bg-white">
            <div class="container-fluid">
                <div class="row jumbotron bg-website">
                    <div class="col-md-1 d-none d-md-block p-0">
                        <i class="las la-lightbulb icon-large mt-1"></i>
                    </div>
                    <div class="col-md-10">
                        <h2>
                            Tips
                        </h2>
                        <h5 class="mt-4">
                            Create an outline.
                        </h5>
                        <p>
                            Decide what skills you’ll teach and how you’ll teach them. Organize lectures into sections. Each section should have 3-7 lectures, and include at least one assignment or practical activity.
                        </p>
                        <h5 class="mt-2">
                            Introduce yourself and create momentum.
                        </h5>
                        <p>
                            People online want to start learning quickly. Make an introduction section that gives students something to be excited about in the first 10 minutes.
                        </p>
                        <h5 class="mt-2">
                            Sections have a clear learning objective.
                        </h5>
                        <p>
                            Introduce each section by describing the section goal and why it’s important. Give lectures and sections titles that reflect their content and have a logical flow                        
                        </p>
                        <h5 class="mt-2">
                            Lectures cover one concept.
                        </h5>
                        <p>
                            A good lecture length is 2-7 minutes, to keep students interested and help them study in short bursts. Make lectures around single topics so students can easily re-watch specific points later.                        </p>
                        <h5 class="mt-2">
                            Mix and match your lecture types.
                        </h5>
                        <p>
                            Alternate between filming yourself, your screen, and slides or other visuals. Showing yourself can help students feel connected.
                        <h5 class="mt-2">
                            Practice activities create hands-on learning.
                        </h5>
                        <p>
                            Help students apply your lessons to their real world with projects, assignments, coding exercises, or worksheets.
                        </div>

                </div>

                <div class="row jumbotron">
                    <div class="col-md-1 d-none d-md-block p-0">
                        <i class="las la-fire icon-large"></i>
                    </div>
                    <div class="col-md-11">
                        <h2>
                            Requirements
                        </h2>
                        <ul class="mt-3">
                            <li>
                                Your course has at least five lectures

                            </li>
                            <li>
                                All lectures add up to at least 30+ minutes of total video

                            </li>
                            <li>
                                You course is composed of valuable educational content
                            </li>
                        </ul>

                    </div>
                </div>

                <div class="row jumbotron">
                    <div class="col-md-1 d-none d-md-block p-0">
                        <i class="las la-bookmark icon-large"></i>
                    </div>
                    <div class="col-md-11">
                        <h2>
                            Resources 
                        </h2>
                        <section class="mt-2">
                            <a href="" > Udemy Trust & Safety </a>
                            <p> Our policies for instructors and students </p>
                        </section>
                        <section class="mt-2">
                            <a href="" > Join the community  </a>
                            <p> A place to talk with other instructors </p>
                        </section>
                    </div>
                </div>
            </div>
            
        </section>

    </div>
    


@endsection

@section('page-js')  
    <script>
        $('#course_structure').removeClass('text-info').addClass('bg-website text-white');
    </script>

@endsection