<?php 

use App\Models\UserAnnModel;
use App\Models\Categories;
use Illuminate\Support\Facades\Cache;

$ann = UserAnnModel::select('message')->orderByDesc('updated_at')->first();
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <link rel="stylesheet" href="{{asset('css/responsive.css')}}">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php
        if($_SERVER['SERVER_NAME'] == 'lyskills.org'){
            echo '<meta name="robots" content="noindex">';
        }
        ?>
        <title id="seo_title"> @if(isset($title)){{ $title }} @else {{ config('app.name') }} @endif </title>
        <meta id="seo_desc" name="description" content="@if(isset($desc) && $desc !== '' ) {{ $desc }} @else {{__('description.default')}}  @endif">
        <meta property="og:title" content="@if(isset($title)){{ $title }} @else {{ config('app.name') }} @endif">
        <meta id="seo_fb" property="og:description" content="@if(isset($desc) && $desc !== '') {{ $desc }} @else {{__('description.default')}}  @endif">
        <link rel="canonical" href="{{ url()->current() }}">
        <link rel="shortcut icon" href="{{asset('img/favicon.png')}}">

        <!-- Fonts -->
        {{-- <link rel="preconnect" href="https://fonts.gstatic.com"> --}}
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

        {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}">         --}}

        <link rel="stylesheet" href="{{ asset('css/text.css') }}">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
                integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
             crossorigin="anonymous"
             >
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <style>
            .loading-section {
                height: 100vh;
                z-index: 9999;
            }
        </style>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-185115352-1"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-185115352-1');
        </script>


        @yield('page-css')
    </head>
    <body style="min-height: 100vh !important" class="d-flex flex-column ">

     @if(!(Cache::store('file')->get('isLoaderLoaded')))
     {!!
       '<section class="d-flex justify-content-center align-items-center loading-section">
            <div id="loading" class="spinner-border text-info text-center" style="width: 90px; height: 90px" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </section>' !!}
        @php Cache::store('file')->put('isLoaderLoaded', true, 3600); @endphp
    @endif
    @if(isset($ann) && $ann->count())
        <div class="container-fluid font-bold text-center" >
            <div class="row">
                <div class="col-12">

                    <div  class="alert alert-info mb-1 font-bold alert-dismissible fade show"
                    role="alert"  style="font-weight: bold"> {{ $ann -> message ?? ''}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <nav class="p-2 d-md-flex justify-content-md-between mb-2 mb-md-0">
        <div class="container-fluid">
        <div class="row">

            <div class="col-md-2">
                <div class="d-md-flex align-items-md-center">
                    <a href="{{route('index')}}" class=""> <img src="{{asset('img/logo.jpg')}}" alt="Lyskills" width="80" class="img-fluid"/>   </a> 
                    <div class="dropdown">
                        <div class="ml-4 cursor_pointer show-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Categories
                        </div>
                        <div class="dropdown-menu categories_menu">
                            @php
                            $cs = Categories::all();
                            @endphp

                            @foreach ($cs as $c )
                                <a class="dropdown-item" href="{{ route('user-categories',['category' => $c->value]) }}">
                                        {{ $c->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <form action="{{route('c-search-page')}}" method="post">
                    <div class="searchbar mt-4 mt-md-0">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input class="search_input" type="text" name="search_course" id="search_course" placeholder="Search Your Favorite Course...">
                        <button type="submit" class="search_icon btn"><i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-md-2">
               <div class="d-md-flex justify-content-end align-items-md-center">
                @auth
                    <a href="{{route('dashboard')}}" class="ml-3 mt-4 mt-md-0"> {{ __('Instructor')}} </a>
                    <a href="{{route('get-wishlist-course')}}" class="ml-3 text-website" style="font-size: 2rem" title="wishlist courses">
                        <i class="fa fa-heart" aria-hidden="true"></i>
                    </a>
                    @else
                    <a href="{{route('dashboard')}}" class="ml-3 mt-5 mt-md-3 text-dark"> {{ __('Teach on Lyskills')}} </a>
                @endif
               </div>
            </div>

              <div class="col-md-2">

                  <div class="d-md-flex align-items-md-center justify-content-md-end">
                      @if (Route::has('login'))
                      @auth
                      <div class="dropdown mx-3">
                        <div class="cursor_pointer text-center  pt-2"
                        id="user_menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img height="50" width="50" class="rounded-circle object-cover" src="@if(Auth::user()->profile_photo_path) {{ asset(Auth::user()->profile_photo_path) }} @else
                        {{ Auth::user()->profile_photo_url }} @endif" alt="{{ Auth::user()->name }}" />

                    </div>
                    <div class="dropdown-menu dropdown-menu-right  w-55 mr-4 border" aria-labelledby="user_menu">
                        <a class="pt-2 dropdown-item" href="{{ route('myLearning') }}"> {{__('My Learning')}}</a>
                        <a class="pt-2 dropdown-item" href="{{ route('get-wishlist-course') }}"> {{__('WishList')}}</a>
                        <a class="pt-2 dropdown-item" href="{{ route('profile.show') }}"> {{__('Setting')}}</a>
                        <div class="dropdown-divider"></div>
                        <a class="pt-2 dropdown-item" href="{{ route('dashboard') }}"> {{__('Instructor Dashboard')}}</a>
                        {{-- <a class="pt-2 dropdown-item" href="{{ route('chat_w_i') }}"> {{__('Contact With Instructor')}}</a>                               --}}
                        <a class="pt-2 dropdown-item" href="{{ route('email_to_ins') }}"> {{__('Contact With Instructor')}}</a>
                        <div class="dropdown-divider"></div>
                        <a class="pt-2 dropdown-item" href="{{ route('pay_his') }}"> {{__('Purchase History')}}</a>
                        <a class="pt-2 dropdown-item" href="{{ route('public_faq') }}"> {{__('Help')}}</a>
                        <a class="pt-1 dropdown-item" href="{{ route('logout') }}"> {{__('Logout')}}</a>
                    </div>
                </div>
                @else
                <div class="d-flex justify-content-end">
                    <a href="{{ route('login') }}" class="btn btn-info mr-1 mt-3">Log in</a>
                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-info mt-3">Sign Up</a>
                        @endif
                    </div>
                @endif

                @endif
            </div>

        </div>
    </div>
    </nav>
        <!-- main Content -->
        <main>
            @yield('content')
        </main>


        @yield('script')
    </body>
</html>
