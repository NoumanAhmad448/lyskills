<?php

use App\Models\UserAnnModel;
use App\Models\Categories;
$ann = UserAnnModel::select('message')->orderByDesc('updated_at')->first();
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <?php
        if($_SERVER['SERVER_NAME'] == 'lyskills.org'){
            echo '<meta name="robots" content="noindex">';
        }
    ?>
    <title id="seo_title"> @if(isset($title)){{ $title }} @else {{ config('app.name') }} @endif </title>
    <meta id="seo_desc" name="description"
        content="@if(isset($desc) && $desc !== '' ) {{ $desc }} @else {{__('description.default')}}  @endif">
    <meta property="og:title" content="@if(isset($title)){{ $title }} @else {{ config('app.name') }} @endif">
    <meta id="seo_fb" property="og:description"
        content="@if(isset($desc) && $desc !== '') {{ $desc }} @else {{__('description.default')}}  @endif">
    <link rel="canonical" href="{{ url()->current() }}">
    @include("lib.custom_lib")
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-185115352-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-185115352-1');
        debug = '{{ config('app.debug') ? 1 : 0 }}'
        debug = debug == "1" ? true : false
    </script>
    @yield('page-css')
</head>

<body style="min-height: 100vh !important" class="d-flex flex-column ">
    @include("modals.modal")
    @if(isset($ann) && $ann->count() && config("setting.user_notification"))
    <div class="container-fluid font-bold text-center">
        <div class="row">
            <div class="col-12">

                <div class="alert alert-info mb-1 alert-dismissible fade show font-bold" role="alert"
                style="font-weight: bold"
                > {{ $ann -> message ?? ''}}
                    <button type="button" id="close_user_notification" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(config('setting.guest_header'))
    <nav class="p-2 d-md-flex justify-content-md-between mb-2 mb-md-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">
                    <div class="d-md-flex align-items-md-center">
                        @if(config("setting.show_site_log"))
                        <a href="{{route('index')}}" class=""> <img src="{{asset('img/logo.jpg')}}" alt="Lyskills"
                        width="80" class="img-fluid" /> </a>
                        @endif
                @if(config("setting.category_menu"))
                    <div class="dropdown">
                        <div class="ml-4 cursor_pointer show-dropdown" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            Categories
                        </div>
                        <div class="dropdown-menu categories_menu">
                            @php
                            $cs = Categories::all();
                            @endphp

                            @foreach ($cs as $c )
                            <a class="dropdown-item"
                                href="{{ route('user-categories',['category' => $c->value]) }}">
                                {{ $c->name }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                @endif
                </div>
            </div>
                @if(config("setting.guest_search_bar"))
                <div class="col-md-5">
                    <form action="{{route('c-search-page')}}" method="post">
                        <div class="searchbar mt-4 mt-md-0">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"
                            />
                            <input class="search_input" type="text" name="search_course" id="search_course"
                                placeholder="Search Your Favorite Course...">
                            <button type="submit" class="search_icon btn"><i class="fa fa-search"s
                                    aria-hidden="true"></i>
                            </button>
                        </div>
                    </form>

                </div>
                @endif
                <div class="col-md-2">
                    <div class="d-md-flex justify-content-end align-items-md-center">
                        @auth
                        <a href="{{route('dashboard')}}" class="ml-3 mt-4 mt-md-0"> {{ 'Instructor'}} </a>
                        <a href="{{route('get-wishlist-course')}}" class="ml-3 text-website" style="font-size: 2rem"
                            title="wishlist courses">
                            <i class="fa fa-heart" aria-hidden="true"></i>
                        </a>
                        @else
                        <a href="{{route('instructor.register')}}" class="ml-3 mt-5 mt-md-3 text-dark">
                            {{ __('Teach on Lyskills')}} </a>
                        @endif
                    </div>
                </div>

                <div class="col-md-3">

                    <div class="d-md-flex align-items-md-center justify-content-md-end">
                        @if (Route::has('login'))
                        @auth
                        <div class="dropdown mx-3">
                            @if(config("setting.login_profile"))
                                <div class="cursor_pointer text-center  pt-2" id="user_menu" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <img height="40" width="40" class="rounded-circle object-cover"
                                    src="@include("modals.profile_logo")" alt="{{ Auth::user()->name }}" />
                                </div>
                            @endif
                            <div class="dropdown-menu dropdown-menu-right  w-55 mr-4 border"
                                aria-labelledby="user_menu">
                                <a style="font-size: 0.9rem !important" class="pt-2  dropdown-item" href="{{ route('myLearning') }}">
                                    {{__('My Learning')}}</a>
                                <a style="font-size: 0.9rem !important" class="pt-2  dropdown-item" href="{{ route('get-wishlist-course') }}">
                                    {{__('WishList')}}</a>
                                <a style="font-size: 0.9rem !important" class="pt-2  dropdown-item" href="{{ route('profile.show') }}"> {{__('Setting')}}</a>
                                <div class="dropdown-divider"></div>
                                <a style="font-size: 0.9rem !important" class="pt-2  dropdown-item" href="{{ route('dashboard') }}">
                                    {{__('Instructor Dashboard')}}</a>
                                {{-- <a style="font-size: 0.9rem !important" class="pt-2  dropdown-item" href="{{ route('chat_w_i') }}">
                                {{__('Contact With Instructor')}}</a> --}}
                                <a style="font-size: 0.9rem !important" class="pt-2  dropdown-item" href="{{ route('email_to_ins') }}">
                                    {{__('Contact With Instructor')}}</a>
                                <div class="dropdown-divider"></div>
                                <a style="font-size: 0.9rem !important" class="pt-2  dropdown-item" href="{{ route('pay_his') }}">
                                    {{__('Purchase History')}}</a>
                                @if(Auth::user()->is_blogger)
                                    <a style="font-size: 0.9rem !important" class="pt-2  dropdown-item" href="{{ route('blogger_c_p') }}">
                                    {{__('Create Blogs')}}</a>
                                @endif
                                <a style="font-size: 0.9rem !important" class="pt-2  dropdown-item" href="{{ route('public_faq') }}"> {{__('Help')}}</a>
                                <a style="font-size: 0.9rem !important" class="pt-1 dropdown-item" href="{{ route('logout_user') }}"> {{__('Logout')}}</a>
                            </div>
                        </div>
                        @else
                        <div class="d-flex justify-content-end">

                            <a href="{{ route('login') }}" class="btn btn-info mr-1 mt-3">Log in</a>
                            @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-info mt-3">{{ __('homepage.instructor.title') }}</a>
                            @endif
                        </div>
                        @endif

                        @endif
                    </div>
                </div>
            </div>
    </nav>
    @endif

    <!-- main Content -->
    <main>
        @yield('content')
    </main>


    @if(config('setting.guest_footer'))
        @include('footer')
    @endif
</body>

</html>