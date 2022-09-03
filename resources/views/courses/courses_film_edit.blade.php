@extends('courses.dashboard_main')
@section('content')
    <div class="col-md-9 bg-white mt-3">
        <h1 class="ml-3 mt-2">
            Film & edit
        </h1>
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-md-8 jumbotron bg-light text-center">
                    <h2>
                        You’re ready to share your knowledge.
                    </h2>
                    <p>
                    This is your moment! If you’ve structured your course and used our guides, you're well prepared for the actual shoot. Pace yourself, take time to make it just right, and fine-tune when you edit.

                    </p>
                </div>

                <div class="col-md-4 bg-website jumbotron text-center">
                    <i class="las la-play-circle icon-large"></i>
                    <h2>
                        You’re in good company
                    </h2>
                    <p>
                        Chat and get production help with other Udemy instructors
                    </p>
                    <a href="" class="btn website-outline" method="_target"> Join the Community </a>
                </div>
            </div>

            <div class="container-fluid mt-3 p-0">
                <div class="row jumbotron">
                    <div class="col-md-1 d-none d-md-block">
                        <i class="las la-random icon-large"></i>
                    </div>
                    <div class="col-md-11">
                        <h2 class="mt-2">
                            Tips
                        </h2>
                        <section class="mt-3">
                            <h3>
                                Take breaks and review frequently.
                            </h3>
                            <p>
                                Check often for any changes such as new noises. Be aware of your own energy levels--filming can tire you out and that translates to the screen.
                            </p>
                        </section>
                        <section class="mt-3">
                            <h3>
                                Build rapport.
                            </h3>
                            <p>
                                Students want to know who’s teaching them. Even for a course that is mostly screencasts, film yourself for your introduction. Or go the extra mile and film yourself introducing each section!
                            </p>
                        </section>
                        <section class="mt-3">
                            <h3>
                                Being on camera takes practice.
                            </h3>
                            <p>
                                Make eye contact with the camera and speak clearly. Do as many retakes as you need to get it right.
                            </p>
                        </section>
                        <section class="mt-3">
                            <h3>
                                Set yourself up for editing success.
                            </h3>
                            <p>
                                You can edit out long pauses, mistakes, and ums or ahs. Film a few extra activities or images that you can add in later to cover those cuts.
                            </p>
                        </section>
                        <section class="mt-3">
                            <h3>
                                Create audio marks.
                            </h3>
                            <p>
                                Clap when you start each take to easily locate the audio spike during editing. Use our guides to manage your recording day efficiently.
                            </p>
                        </section>
                        <section class="mt-3">
                            <h3>
                                For screencasts, clean up.
                            </h3>
                            <p>
                                Move unrelated files and folders off your desktop and open any tabs in advance. Make on-screen text at least 24pt and use zooming to highlight.
                            </p>
                        </section>
                    </div>
                </div>

                <div class="row jumbotron bg-website">
                    <div class="col-md-1 d-none d-md-block">
                        <i class="las la-compress icon-large"></i>
                    </div>
                    <div class="col-md-11">
                        <h2>
                            Requirements
                        </h2>
                        <ul class="mt-2">
                            <li>
                                <div>
                                    Film and export in HD to create videos of at least 720p, or 1080p if possible
                                </div>
                            </li>
                            <li>
                                <div >Audio should come out of both the left and right channels and be synced to your video</div>
                            </li>
                            <li>
                                <div >Audio should be free of echo and background noise so as not to be distracting to students</div>
                            </li>
                            </ul>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-1 d-none d-md-block">
                        <i class="las la-microphone-alt icon-large"></i>
                    </div>
                    <div class="col-md-11">
                        <h2> Resources </h2>
                        <section class="mt-3">
                            <a href="http://" target="_blank" > udemy trush & safety </a>
                            <p>
                                Our policies for instructors and students
                            </p>
                        </section>
                        <section class="mt-3">
                            <a href="http://" target="_blank" > how to make and edit video  </a>
                            <p>
                                our guide to create a video and edit it using recommended software
                            </p>
                        </section>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('page-js')
<script>
    $('#film_edit').removeClass('text-info').addClass('bg-website text-white');
</script>
@endsection