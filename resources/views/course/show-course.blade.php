@php
use App\Models\Lecture;
use App\Models\User;
use App\Models\WishList;
use App\Models\CourseEnrollment;
use Carbon\Carbon;
@endphp
@extends(config('setting.guest_blade'))

@section('page-css')
<meta property="og:url" content="{{route('user-course' , ['slug' => $course->slug])}}" />
<meta property="og:type" content="website" />
<meta property="og:image"
    content="@if(empty($c_img))  {{asset('img/logo.jpg')}} @else  {{ config('setting.s3Url').$c_img }} @endif" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vidstack/styles/defaults.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vidstack/styles/community-skin/video.min.css" />
    <script type="module" src="https://cdn.jsdelivr.net/npm/vidstack/dist/cdn/prod.js"></script>
@endsection

@section('content')
@if(config('setting.course_banner'))
<section class="my-1 bg-static">
    <div class="container">
        <div class="row">
            <div class="col-md-10 p-4 py-5">
                @include('session_msg')
                @if(config("setting.course_nav"))
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-white text-dark">
                            @if($course->categories_selection) <li class="breadcrumb-item text-capitalize"> <a
                                    href="{{route('user-categories', ['category' => $course->categories_selection] )}}">
                                    {{ $course->categories_selection ?? ''  }} </a> </li> @endif
                            <li class="breadcrumb-item active" aria-current="page"> {{ $course->slug ?? '' }} </li>
                        </ol>
                    </nav>
                @endif
                <h1 class="text-capitalize" style="font-weight: bold!important"> {{ $course->course_title ?? '' }} </h1>
                <div class="mt-2" class="text-justify">
                    {{ reduceCharIfAv($course->description ?? '', 200) }}
                </div>
                <div class="mt-2 text-uppercase">
                    created by <a class="text-warning"  href="#profile"> {{ $course->user->name ?? '' }} </a>
                </div>

                @if($rating_avg)
                <div class="d-flex align-items-center">
                    <section id="rating" class="d-flex align-items-center" style="cursor: pointer">
                        <span class="fa fa-2x fa-star rating" no="1"></span>
                        <span class="fa fa-2x fa-star ml-1 rating" style="text-size: 1.3rem;" no="2"></span>
                        <span class="fa fa-2x fa-star ml-1 rating" style="text-size: 1.3rem;" no="3"></span>
                        <span class="fa fa-2x fa-star ml-1 rating" style="text-size: 1.3rem;" no="4"></span>
                        <span class="fa fa-2x fa-star ml-1 rating" style="text-size: 1.3rem;" no="5"></span>
                    </section>
                    <section class="ml-1">
                        {{$rated_by_students}} Students
                    </section>
                </div>
                @endif

                <div class="mt-2">
                    Last updated {{ Carbon::parse($course->updated_at)->toDateString() ?? '' }}
                </div>
                @if(!empty($total_en) && config("setting.course_enrollment_count"))
                <div class="m2-1">
                    Enrollment: {{ $total_en ?? '' }}
                </div>
                @endif
                @if($course && $course->lang && $course->lang->name ?? '')
                <div class="m2-1">
                    Language: {{ $course->lang->name ?? '' }}
                </div>
                @endif



                <div class="mt-2">
                    <section class="d-flex">
                        @if(config("setting.course_desc_wishlist_btn"))
                            <form action="{{route('wishlist-course-post', ['slug' => $course->slug])}}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-light">
                                    @auth
                                    @if(WishList::where('user_id' , auth()->id())->where('c_id', $course->id)->first())
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                    @else
                                    <i class="fa fa-heart-o text-website" aria-hidden="true"></i>
                                    @endif
                                    @endauth
                                    @guest
                                    <i class="fa fa-heart-o text-website" aria-hidden="true"></i>
                                    @endguest
                                    Wishlist
                                </button>
                            </form>
                        @endif
                        @if(config('setting.course_desc_share_btn'))
                            <div link="{{route('user-course' , ['slug' => $course->slug ])}}" id="share_course"
                                class="btn btn-light ml-2"> <i class="fa fa-share-square-o" aria-hidden="true"></i>
                                Share
                            </div>
                        @endif
                        @if(config('setting.course_desc_gift_btn'))
                            <a href="" class="btn btn-light ml-2"> <i class="fa fa-gift" aria-hidden="true"></i>
                                    Gift Course
                            </a>
                        @endif
                    </section>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<div class="d-md-none">
    <div class="border">
        <?php
            $c_vid = $course->course_vid;
        ?>
        @if($c_vid && $c_vid->vid_path)
            <video controls class="w-100">
                <source src="{{config('setting.s3Url')}}{{ $c_vid->vid_path }}"
                    type="{{$c_vid->video_type ?? '' }}">
                Your browser does not support the video tag
            </video>
        @endif
        <div class="px-2">
            @php $price = $course->price; @endphp
            @if($price)
            <section class="d-flex ">
                @if($price->is_free)
                <div class="mt-2 h3"> FREE </div>
                @else

                @php $total_p = $price->pricing; @endphp
                <section class="d-flex align-items-center">
                    <div class="mt-2 h3"> ${{$total_p}} </div>
                    @php $total_p = ((int)$total_p)+20 @endphp
                    <div class="ml-3"> <del> ${{ $total_p }} </del> </div>
                </section>
                @endif
            </section>
            @endif
            @auth
            @php
            $u_id = auth()->id();
            $enrolled_s = CourseEnrollment::where('user_id',$u_id)->where('course_id',$course->id)->first();
            @endphp
            @unless($price && $price->is_free || allowCourseToAdmin() || $u_id == $course->user_id || ($enrolled_s &&
            $enrolled_s->count()))
            <a href="{{route('a_payment_methods', ['slug' => $course->slug])}}"
                class="btn btn-lg btn-block btn-outline-website"> Buy Now </a>
            @elseif($price && $price->is_free && $enrolled_s == null)
            <form action="{{route('enroll-now', ['course' => $course->id])}}" method="post">
                @csrf
                <input type="submit" class="btn btn-lg btn-block btn-outline-website" value="Enroll Now" />
            </form>
            @endunless

            @if ($course->slug )
            @if($course->lecture)
            @if( $course->lecture->media)
            @if($course->lecture && $course->lecture->media && $course->lecture->media->lec_name)
            @if(allowCourseToAdmin()
            || auth()->id() == $course->user_id || ($enrolled_s && $enrolled_s->count()))
            <a href="{{route('video-page', ['slug' => $course->slug, 
                        'video' => explode('/',$course->lecture->media->lec_name)[1]])}}"
                class="btn btn-lg btn-block btn-outline-website"> Start Course </a>
            @endif
            @endif
            @endif
            @endif
            @endif
            @endauth
            @guest
            @unless($price && $price->is_free)
            <a href="{{route('a_payment_methods', ['slug' => $course->slug])}}"
                class="btn btn-lg btn-block btn-outline-website"> Buy Now </a>
            @endunless
            @if($price && $price->is_free)
            <form action="{{route('enroll-now', ['course' => $course->id])}}" method="post">
                @csrf
                <input type="submit" class="btn btn-lg btn-block btn-outline-website" value="Enroll Now" />
            </form>
            @endif
            @endguest

            <div class="text-center text-website d-none"> 30 days money back guarantee</div>
            <div class="mt-3">
                <div class="font-bold"> This course has</div>
                <div> <i class="fa fa-star-o" aria-hidden="true"></i>
                    Full Lifetime Access </div>
                <div><i class="fa fa-star-o" aria-hidden="true"></i>
                    Access on mobile </div>
                <div><i class="fa fa-star-o" aria-hidden="true"></i>
                    Certificate of Completion </div>
                @php $quizzes = $course->quizzes->count(); @endphp
                @if($quizzes)
                <div> {{ $quizzes }} Quizzes </div>
                @endif
                @php $ass = $course->assignments->count(); @endphp
                @if($ass)
                <div> {{ $ass }} Assignments </div>
                @endif
            </div>
                <section class="apply_coupon my-3">
                    <form action="{{route('coupon')}}" method="post">
                        @csrf
                        <div class="d-flex">
                            <input type="text" name="coupon" id="coupon" placeholder="Coupon" value="{{old('coupon')}}"
                                class="@error('coupon') is-invalid @enderror form-control">
                            <input type="hidden" name="course" value="{{$course->id}}">
                            <button type="submit" class="btn btn-website btn-sm ml-1">
                                Confirm
                            </button>
                        </div>

                    </form>

                </section>
        </div>

    </div>
</div>
<div class="container mt-3">
    <div class="row">

        <div class="col-md-8">
            <div class="jumbotron pt-3 bg-white">

                @php
                $learnable_skill = json_decode($course->learnable_skill)
                @endphp

                @if($learnable_skill)
                <h2 class="mt-1" style="">
                    {{ __('Your Coverages')  }}
                </h2>
                <ul class="pl-2 mt-2" style="list-style-type: none">
                    <div class="row">
                        @foreach ($learnable_skill as $skill)
                        <div class="col-md-6 d-flex mt-1">
                            <i class="fa fa-star-o" aria-hidden="true"></i>
                            <li class="ml-2"> {{ $skill }} </li>
                        </div>
                        @endforeach
                    </div>
                </ul>
                @endif
            </div>
            <hr />

            <div class="jumbotron pt-3 bg-white">

                @php
                $course_requirements = json_decode($course->course_requirement)
                @endphp

                @if($course_requirements)
                <ol class="pl-2 mt-2" style="list-style-type: none">
                    <h2 class="mt-1">
                        {{ __('Course Requirements')  }}
                    </h2>
                    <div class="row">
                        @foreach ($course_requirements as $skill)
                        <div class="col-md-6 d-flex mt-1">
                            <i class="fa fa-star-o" aria-hidden="true"></i>
                            <li class="ml-2"> {{ $skill }} </li>
                        </div>
                        @endforeach
                    </div>
                </ol>
                @endif
            </div>
            <hr />
            <div class="jumbotron pt-3 bg-white">

                @php
                $targeting_student = json_decode($course->targeting_student);
                @endphp

                @if($targeting_student)
                <ol class="pl-2 mt-2" style="list-style-type: none">
                    <h2 class="mt-1">
                        {{ __('Which Students must take this course')  }}
                    </h2>
                    <div class="row">
                        @foreach ($targeting_student as $skill)
                        <div class="col-md-6 d-flex mt-1">
                            <i class="fa fa-star-o" aria-hidden="true"></i>
                            <li class="ml-2"> {{ $skill }} </li>
                        </div>
                        @endforeach
                    </div>
                </ol>
                @endif
            </div>
            <hr />
            @if(config("setting.show_hide_course_content"))
                <div class="course_content">
                    <section class="my-4  ml-4 d-flex justify-content-between align-items-center">
                        <h2 class=""> Course Content </h2>
                        <div id="show_time"> </div>
                    </section>

                    <div class="accordion mt-2" id="course_content">
                        <div class="card">
                            @php $sections = $course->sections;
                            $total_time = 0;
                            @endphp

                            @if (isset($sections) && $sections->count())
                            @foreach ($sections as $sec)
                            <div class="card-header" id="headingOne">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left font-bold text-dark text-capitalize"
                                            style="font-size: 1.2rem;" type="button" data-toggle="collapse"
                                            data-target="#section{{$sec->id}}" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            {{ $sec->section_title ?? '' }}
                                        </button>
                                    </h2>
                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                        data-target="#section{{$sec->id}}" aria-expanded="true" aria-controls="collapseOne">
                                        <i class="fa fa-angle-double-down" aria-hidden="true"></i>
                                    </button>
                                </div>

                            </div>
                            <div id="section{{$sec->id}}" class="collapse show @if($sec->section_no == 1 )  @endif"
                                aria-labelledby="headingOne" data-parent="#course_content">
                                <div class="card-body">
                                    @php $lectures = Lecture::where('course_id', $course->id)->where('sec_no',
                                    $sec->section_no)->get();
                                    @endphp
                                    @if($lectures->count())
                                    @foreach ($lectures as $lec)
                                    <section class="row">
                                        <?php
                                            if($lec->count()) { $media = $lec->media;}
                                            if($media){ $total_time += $media->time_in_mili;}
                                            $is_media_free = $media && $media->is_free;
                                            $col =  $is_media_free ? 'col-9' : 'col-10';
                                        ?>
                                        <div class="{{$col}}"> <i class="fa fa-video-camera mr-2" aria-hidden="true"></i>
                                            <span class="@if($is_media_free) cursor-p text-info show_popup @endif"
                                            @if($media)
                                                url="{{config('setting.s3Url')}}{{ $media->lec_name }}"
                                            @endif
                                            >
                                                {{ $lec->lec_name ?? '' }}
                                            </span>
                                        </div>
                                        @if($media)
                                            @if($media->is_free)
                                                <div class="show_popup col-1 cursor-p"
                                                url="{{config('setting.s3Url')}}{{ $media->lec_name }}"
                                                > <i class="fa fa-eye mr-2" aria-hidden="true"></i></div>
                                             @endif
                                            <div class="col-2">
                                                {{ $media->duration ?? '' }}
                                            </div>
                                        @endif

                                    </section>
                                    {{-- @php $res_video = $lec->res_vid; @endphp --}}
                                    {{-- @if($res_video)
                                                            <div>
                                                                <i class="fa fa-video-camera mr-2" aria-hidden="true"></i>
                                                                {{ $res_video->f_name ?? '' }}
                                </div>
                                @endif
                                @php $article = $lec->article; @endphp
                                @if($article)
                                <div>
                                    <i class="fa fa-file-text mr-2" aria-hidden="true"></i>
                                    {{ reduceCharIfAv($article->article_txt ?? '' , 50) }}
                                </div>
                                @endif
                                @php $ex_res = $lec->ex_res; @endphp
                                @if($ex_res)
                                <div>
                                    <i class="fa fa-file-text mr-2" aria-hidden="true"></i>
                                    {{ $ex_res->title ?? ''  }}
                                </div>
                                @endif
                                @php $other_file = $lec->other_file; @endphp
                                @if($other_file)
                                <div>
                                    <i class="fa fa-file-text mr-2" aria-hidden="true"></i>
                                    {{ $other_file->saved_f_name ?? ''  }}
                                </div>
                                @endif --}}
                                {{-- @php $assign = $lec->assign; @endphp
                                                        @if($assign->count())
                                                            @foreach ($assign as $ass)
                                                                <div>
                                                                    <i class="fa fa-file-text mr-2" aria-hidden="true"></i>
                                                                    {{ $ass->title ?? ''  }}
                            </div>
                            @endforeach
                            @endif
                            @php $quizzs = $lec->quizzs; @endphp
                            @if($quizzs->count())
                            @foreach ($quizzs as $q)
                            <div>
                                <i class="fa fa-file-text mr-2" aria-hidden="true"></i>
                                {{ $q->title ?? ''  }}
                            </div>
                            @endforeach
                            @endif --}}


                            @endforeach
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @endif

                    @php $total_time = Carbon::parse($total_time)->toTimeString(); @endphp
                    <input type="hidden" id="total_time" value="{{$total_time}}">

                </div>
            @endif
        </div>
    </div>

    @if($course->description && config("setting.show_hide_course_desc"))
    <div class="mt-2 jumbotron bg-white pt-3">
        <h2> Description </h2>
        <div id="course_desc" class="mt-3 text-justify">
            {{ $course->description ?? '' }}
        </div>
    </div>
    <hr />
    @endif
    @php
    $profile = $course->user->profile ?? ""
    @endphp
    @if($profile)
    <div class="mt-2 jumbotron pt-3 bg-white" id="profile">
        <h2> Instructor Profile </h2>
        <div class="mt-3">
            <div class="row">
                <div class="col-1">
                    <img height="50" width="50" class="rounded-circle object-cover" src="@if($course->user && $course->user->profile_photo_path) {{ asset($course->user->profile_photo_path) }} @else
                                    {{ $course->user() ? $course->user()->profile_photo_url : '' }} @endif" alt="{{ $course->user->name ?? '' }}" />
                </div>
                <div class="col-7">
                    <div class="text-uppercase"> {{ $course->user->name ?? ''}} </div>
                    <div class="text-capitalize"> {{ $profile->headline ?? ''}} </div>
                </div>
            </div>
            <div class="mt-1">
                {{ $profile->bio ?? '' }}
            </div>
        </div>
    </div>
    @endif


    @if($rating_avg)
    <section class="mb-5">
        <h3> Students Ratings </h3>
        <div style="font-size: 2rem;
        padding-left: 0.5rem;
        margin-top: 2rem;">
            Rating Point {{ round($rating_avg, 2) ?? '' }}
        </div>
        <div class="d-flex align-items-center">
            <section id="rating" class="d-flex align-items-center" style="cursor: pointer">
                <span class="fa fa-2x fa-star       @if($rating_avg >= 1) {{ 'text-warning'}} @endif" no="1"></span>
                <span class="fa fa-2x fa-star ml-1  @if($rating_avg >= 2) {{ 'text-warning'}} @endif" style="text-size: 1.3rem;" no="2"></span>
                <span class="fa fa-2x fa-star ml-1  @if($rating_avg >= 3) {{ 'text-warning'}} @endif" style="text-size: 1.3rem;" no="3"></span>
                <span class="fa fa-2x fa-star ml-1  @if($rating_avg >= 4) {{ 'text-warning'}} @endif" style="text-size: 1.3rem;" no="4"></span>
                <span class="fa fa-2x fa-star ml-1  @if($rating_avg >= 5) {{ 'text-warning'}} @endif" style="text-size: 1.3rem;" no="5"></span>
            </section>
            <section class="ml-1">
                {{$rated_by_students}} Students
            </section>
        </div>
    </section>
    @endif

    @if(isset($comments) && count($comments) > 0)
    <h3> Comments </h3>
    @foreach ($comments as $c)
    @php $user = User::where('id', $c->user_id)->first(); @endphp
    <section class="row my-3">
        <div class="col-2">
            <img height="50" width="50" class="rounded-circle object-cover" src="@if($user && $user->profile_photo_path) {{ asset($user->profile_photo_path) }} @else
                                {{ $user ? $user->profile_photo_url : '' }} @endif" alt="{{ $user->name ?? '' }}" />
        </div>
        <div class="col">
            <div style="font-weight: bold" class="text-capitalize">{{$user->name ?? ''}}</div>
            @php if(isset($c)) { $rate = $c->rating ? $c->rating->rating: 0; }@endphp
            @if(isset($rate) && $rate > 0)
                <div class="d-flex align-items-center">
                    <section id="rating" class="d-flex align-items-center" style="cursor: pointer">
                        <span class="fa fa-star       @if($rate >= 1) {{ 'text-warning'}} @endif" no="1"></span>
                        <span class="fa fa-star ml-1  @if($rate >= 2) {{ 'text-warning'}} @endif" style="text-size: 1.3rem;" no="2"></span>
                        <span class="fa fa-star ml-1  @if($rate >= 3) {{ 'text-warning'}} @endif" style="text-size: 1.3rem;" no="3"></span>
                        <span class="fa fa-star ml-1  @if($rate >= 4) {{ 'text-warning'}} @endif" style="text-size: 1.3rem;" no="4"></span>
                        <span class="fa fa-star ml-1  @if($rate >= 5) {{ 'text-warning'}} @endif" style="text-size: 1.3rem;" no="5"></span>
                    </section>
                </div>
            @endif
            <div class="mb-2">{{$c->comment}}</div>
        </div>
    </section>
    @endforeach
    @endif
</div>
<div class="col-md-4 d-none d-md-block">
    <div class="border p-1">
        <?php
            $c_vid = $course->course_vid;
        ?>
        @if($c_vid && $c_vid->vid_path && config("setting.show_course_video"))
            <media-player
                src="{{config('setting.s3Url')}}{{ $c_vid->vid_path }}"
                aspect-ratio="16/9"
                id="vid01"
                >
                <media-outlet>
                <media-seek-button seconds="+30">
                    <media-tooltip position="top center">
                        <span>Seek +30s</span>
                    </media-tooltip>
                </media-seek-button>
                <media-seek-button seconds="-30">
                <media-tooltip position="top center">
                        <span>Seek -30s</span>
                    </media-tooltip>
                </media-seek-button>
                </media-outlet>
                <media-community-skin></media-community-skin>
            </media-player>
        @endif
        <div class="px-2">
            @php $price = $course->price; @endphp
            @if($price)
            <section class="d-flex ">
                @if($price->is_free)
                <div class="mt-2 h3"> FREE </div>
                @else

                @php $total_p = $price->pricing; @endphp
                <section class="d-flex align-items-center">
                    <div class="mt-2 h3"> ${{$total_p}} </div>
                    @php $total_p = ((int)$total_p)+20 @endphp
                    <div class="ml-3"> <del> ${{ $total_p }} </del> </div>
                </section>
                @endif
            </section>
            @endif
            {{-- @unless($price->is_free) <a href="" class="btn btn-lg btn-block btn-website">Add to Cart</a> @endunless --}}
            @auth
            @php
            $u_id = auth()->id();
            $enrolled_s = CourseEnrollment::where('user_id',$u_id)->where('course_id',$course->id)->first();
            @endphp
            @unless($price && $price->is_free || allowCourseToAdmin() || $u_id == $course->user_id || ($enrolled_s &&
            $enrolled_s->count()))
            <a href="{{route('a_payment_methods', ['slug' => $course->slug])}}"
                class="btn btn-lg btn-block btn-outline-website"> Buy Now </a>
            @elseif($price && $price->is_free && $enrolled_s == null)
            <form action="{{route('enroll-now', ['course' => $course->id])}}" method="post">
                @csrf
                <input type="submit" class="btn btn-lg btn-block btn-outline-website" value="Enroll Now" />
            </form>
            @endunless

            @if ($course->slug )
            @if($course->lecture)
            @if( $course->lecture->media)
            @if($course->lecture->media->lec_name)
            @if(allowCourseToAdmin()
            || auth()->id() == $course->user_id || ($enrolled_s && $enrolled_s->count()))
            <a href="{{route('video-page', ['slug' => $course->slug, 
                                'video' => explode('/',$course->lecture->media->lec_name)[1]])}}"
                class="btn btn-lg btn-block btn-outline-website"> Start Course </a>
            @endif
            @endif
            @endif
            @endif
            @endif
            @endauth
            @guest
            @unless($price && $price->is_free)
            <a href="{{route('a_payment_methods', ['slug' => $course->slug])}}"
                class="btn btn-lg btn-block btn-outline-website"> Buy Now </a>
            @endunless
            @if($price && $price->is_free)
            <form action="{{route('enroll-now', ['course' => $course->id])}}" method="post">
                @csrf
                <input type="submit" class="btn btn-lg btn-block btn-outline-website" value="Enroll Now" />
            </form>
            @endif
            @endguest

            <div class="text-center text-website d-none"> 30 days money back guarantee</div>
            <div class="mt-3">
                <div class="font-bold"> This course has</div>
                <div> <i class="fa fa-star-o" aria-hidden="true"></i>
                    Full Lifetime Access </div>
                <div><i class="fa fa-star-o" aria-hidden="true"></i>
                    Access on mobile </div>
                <div><i class="fa fa-star-o" aria-hidden="true"></i>
                    Certificate of Completion </div>
                @php $quizzes = $course->quizzes->count(); @endphp
                @if($quizzes)
                <div> {{ $quizzes }} Quizzes </div>
                @endif
                @if(!empty($total_time) && $total_time)
                <i class="fa fa-star-o" aria-hidden="true"></i> total time {{ $total_time }}
                @endif
                @php $ass = $course->assignments->count(); @endphp
                @if($ass)
                <div> {{ $ass }} Assignments </div>
                @endif
            </div>
            @auth
            @if(config('setting.show_hide_coupon') && (!($enrolled_s && $enrolled_s->count()) && !allowCourseToAdmin()) &&
             auth()->id() != $course->user_id
            )
            <section class="apply_coupon my-3">
                <form action="{{route('coupon')}}" method="post">
                    @csrf
                    <div class="d-flex">
                        <input type="text" name="coupon" id="coupon" placeholder="Coupon" value="{{old('coupon')}}"
                            class="@error('coupon') is-invalid @enderror form-control">
                        <input type="hidden" name="course" value="{{$course->id}}">
                        <button type="submit" class="btn btn-website btn-sm ml-1">
                            Confirm
                        </button>
                    </div>
                    {{-- <div class="col-6">
                                        </div> --}}
                </form>
                {{-- </div> --}}
                {{-- </div> --}}
            </section>
            @endif
            @else
            <div class="my-2 text-danger"> Login to buy course using coupon option here </div>
            @endauth
        </div>

    </div>
</div>
</div>
</div>


<div class="modal" tabindex="-1" id="course_share_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-static-website">
                <h5 class="modal-title"> Share Course </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="share_m_body">
                <div class="">
                    <div class="mr-2" id="show_link">
                    </div>
                    <div class="d-flex justify-content-end">
                        <input type="hidden" id="link" value="{{route('user-course' , ['slug' => $course->slug])}}">
                        <div class="btn btn-website" id="copy_url"> Copy Link</div>
                    </div>
                    <div id="show_msg" clas="text-success">
                    </div>
                </div>
                <section class="d-flex justify-content-between mt-3">
                    <div>
                        <span class="">
                            <a target="_blank" style="border: 1px solid #0f7c80; color: #0f7c80"
                                href="https://www.facebook.com/sharer/sharer.php?u={{route('user-course' , ['slug' => $course->slug])}}&amp;src=sdkpreparse"
                                class="btn btn-wesbite btn-sm"><i class="fa fa-facebook-official"
                                    aria-hidden="true"></i> Facebook </a>
                        </span>
                        {{-- <div class="fb-share-button" data-href="{{ route('user-course' , ['slug' => $course->slug]) }}"
                        data-layout="button_count"
                        data-size="large"><a target="_blank"
                            href="https://www.facebook.com/sharer/sharer.php?u={{route('user-course' , ['slug' => $course->slug])}}&amp;src=sdkpreparse"
                            class="fb-xfbml-parse-ignore">Share</a></div> --}}

                    <a href="mailto:your_friend_email@gmail.com?subject=New%20Course
                    &body={{ route('user-course' , ['slug' => $course->slug]) }}" class="btn btn-website btn-sm"
                        target="_blank">
                        <i class="fa fa-envelope-o" aria-hidden="true"></i> Email </a>
                    <a href="https://api.whatsapp.com/send?text={{route('user-course' , ['slug' => $course->slug])}}"
                        class="btn btn-sm btn-website" target="_blank">
                        <i class="fa fa-whatsapp" aria-hidden="true"></i> Whatsapp</a>
            </div>
            <div>
                <script src="https://platform.linkedin.com/in.js" type="text/javascript">
                    lang: en_US
                </script>
                <script type="IN/Share" data-url="{{ route('user-course' , ['slug' => $course->slug]) }}"></script>
            </div>
            </section>
        </div>
        {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-website" data-dismiss="modal">Close</button>
                </div> --}}
    </div>
</div>
</div>
</div>

<div aria-live="polite" aria-atomic="true" style=" min-height: 200px;width: 200px">
    <div class="toast" style="position: absolute; top: 20; right: 0;">
        <div class="toast-header">
            <strong class="mr-auto">Message</strong>
            <small>1 sec ago</small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            URL has been copied
        </div>
    </div>
</div>

@endsection

@section('script')
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v10.0"
    nonce="ZLsPGZPg"></script>
<script>
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    var rating = '{{$rating_avg}}';
</script>
<script src="{{asset('js/course/show-course.js')}}">
</script>

@endsection

