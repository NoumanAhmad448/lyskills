@extends('courses.dashboard_main')
@section('content')
    <div class="col-md-9 bg-light mt-3">
        <h1 class="mt-2">
            Setup & test video
        </h1>
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-8 jumbotron bg-website text-center">
                    <h2 class="pt-3">
                        Arrange your ideal studio and get early feedback
                    </h2>
                    <p>
                        It's important to get your audio and video set up correctly now, because it's much more difficult to fix your videos after you’ve recorded. There are many creative ways to use what you have to create professional looking video.

                    </p>
                </div>
                <div class="col-md-4 bg-light jumbotron text-center">
                    <i class="las la-file-video icon-large"></i>
                    <h2>
                        Free expert video help
                    </h2>
                    <p>
                        Get personalized advice on your audio and video
                    </p>
                    <a href="{{}}" class="btn website-outline" method="_target">
                        Check our Guide
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-1 d-none d-md-block p-0">
                    <i class="las la-sun icon-large"></i>
                </div>
                <div class="col-md-11">
                    <h2>
                        Tips
                    </h2>
                    <h3 class="mt-3 mt-md-4">
                        Equipment can be easy.
    
                    </h3>
                    <p>
                        You don’t need to buy fancy equipment. Most smartphone cameras can capture video in HD, and you can record audio on another phone or external microphone.
                    </p>
                    <h3 class="mt-2 mt-md-4">
                        Students need to hear you.
    
                    </h3>
                    <p>
                        A good microphone is the most important piece of equipment you will choose. There are lot of affordable options.. Make sure it’s correctly plugged in and 6-12 inches (15-30 cm) from you.
                    </p>
                    <h3 class="mt-2 mt-md-4">
                        Make a studio.
    
                    </h3>
                    <p>
                        Clean up your background and arrange props. Almost any small space can be transformed with a backdrop made of colored paper or an ironed bed sheet.
                    </p>
                    <h3 class="mt-2 mt-md-4">
                        Light the scene and your face.
    
                    </h3>
                    <p>
                        Turn off overhead lights. Experiment with three point lighting by placing two lamps in front of you and one behind aimed on the background.
                    </p>
                    <h3 class="mt-2 mt-md-4">
                        Reduce noise and echo.
    
                    </h3>
                    <p>
                        Turn off fans or air vents, and record at a time when it’s quiet. Place acoustic foam or blankets on the walls, and bring in rugs or furniture to dampen echo.
                    </p>
                    <h3 class="mt-2 mt-md-4">
                        Be creative.
    
                    </h3>
                    <p>
                        Students won’t see behind the scenes. No one will know if you’re surrounded by pillows for soundproofing...unless you tell other instructors in the community!
                    </p>
                </div>
    
            </div>
            <div class="row mt-5 bg-website text-white jumbotron">
                <div class="col-md-1 d-none d-md-block p-0">
                    <i class="las la-info-circle icon-large "></i>
                </div>
                <div class="col-md-11">
                    <h2>
                        Requirements
                    </h2>
                    <ul>
                        <li>
                            Film and export in HD to create videos of at least 720p, or 1080p if possible 
                        </li>
                        <li>
                            Audio should come out of both the left and right channels and be synced to your video
                        </li>
                        <li>
                            Audio should be free of echo and background noise so as not to be distracting to students
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row mt-5 jumbotron">
                <div class="col-md-1 d-none d-md-block p-0">
                    <i class="las la-grip-lines icon-large"></i>
                </div>
                <div class="col-md-11">
                    <h2>
                        Resources
                    </h2>

                    <section class="mt-3">
                        <a href="" method="_target">Teach Hub: Guide to equipment</a>
                        <p>Make a home studio on a budget
                        </p>
                    </section>
                    <section class="mt-3">
                        <a href="">
                            lyskills Trust & Safety
                        </a>
                        <p>
                            Our policies for instructors and students
                        </p>
                    </section>
                    <section class="mt-3">
                        <a href="" method="_target">
                            Join the community
                        </a>
                        <p>
                            A place to talk with other instructors
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')  
    <script>
        $('#course_setup').removeClass('text-info').addClass('bg-website text-white');
    </script>

@endsection