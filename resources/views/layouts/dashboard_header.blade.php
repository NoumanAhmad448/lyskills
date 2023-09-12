<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title> @if(isset($title)) {{ $title }} @else {{ config('app.name') }} @endif </title>
        <meta name="description" content="@if(isset($desc)) {{ $desc }} @else {{ __('description.default') }}  @endif">
        <meta property="og:title" content="@if(isset($title)){{ $title }} @else {{ config('app.name') }} @endif">
        <meta property="og:description" content="@if(isset($desc)) {{ $desc }} @else {{__('description.default')}}  @endif">
        <link rel="canonical" href="{{ url()->current() }}">
        <link rel="shortcut icon" href="{{asset('img/favicon.png')}}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&amp;display=swap" rel="stylesheet">

        <!-- Styles -->
        {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
        {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}

        <!-- bootstrap 4.5.3 -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        @livewireStyles

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.js" defer></script>

        <link rel="stylesheet" href="{{ asset('css/text.css') }}">
        <!-- line awesome  -->
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

        @yield('page-css')
    </head>
    <body>
    @include("modals.modal")
        <div class="d-flex justify-content-between align-items-center px-4 pt-4">
                {{-- @livewire('navigation-dropdown') --}}
                @if(config("setting.show_site_log"))
                    <a href="{{ route('index') }}">
                        <img src="{{asset('img/logo.jpg')}}" alt="lyskills" class="img-fluid" width="80"/>
                    </a>
                @endif
                <section class="d-flex align-items-center">
                    <a href="{{ route('index') }}" class="mr-3 d-none d-md-block" > {{__('Student')}}  </a>
                <a href="{{ route('dashboard') }}" class="mr-3 d-none d-md-block">
                    Your Dashboard
                </a>
                <div class="dropdown mx-3">
                    @if(config("setting.login_profile"))
                        <div class="cursor_pointer text-center  pt-2" id="user_menu" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img height="40" width="40" class="rounded-circle object-cover"
                                src="@if(Auth::user()->profile_photo_path) {{ asset(Auth::user()->profile_photo_path) }} @else
                                {{ Auth::user()->profile_photo_url }} @endif" alt="{{ Auth::user()->name }}" />
                        </div>
                     @endif
                    <div class="dropdown-menu dropdown-menu-right  w-55 mr-4 border"
                        aria-labelledby="user_menu">
                        <a style="font-size: 0.9rem !important" class="pt-2 dropdown-item" href="{{ route('dashboard') }}">
                            {{__('Dashboard')}}</a>
                        <a style="font-size: 0.9rem !important" class="pt-2 dropdown-item" href="{{ route('i-profile') }}">
                            {{ __('Instructor Profile') }}</a>
                        <a style="font-size: 0.9rem !important" class="pt-2 dropdown-item" href="{{ route('i-payment-setting') }}">
                            {{ __('Withdraw Payment') }}
                        <div class="dropdown-divider"></div>
                        <a style="font-size: 0.9rem !important" class="pt-2 dropdown-item" href="{{  route('profile.show') }}">
                            {{ __('Setting')}}</a>

                        <a style="font-size: 0.9rem !important" class="pt-2 dropdown-item" href="{{ route('public-ann') }}">
                            {{  __('Public Announcement') }}</a>
                        <a style="font-size: 0.9rem !important" class="pt-2 dropdown-item" href="{{ route('purHis') }}">
                            {{__('Earning History')}}</a>
                        <a style="font-size: 0.9rem !important" class="pt-2 dropdown-item" href="{{ route('public_faq') }}"> {{__('Help')}}</a>
                        <a style="font-size: 0.9rem !important" class="pt-1 dropdown-item" href="{{ route('logout') }}"> {{__('Logout')}}</a>
                    </div>
                </div>
                </section>
        </div>
            <!-- Page Heading -->
            <header class="bg-white">
                <div class="mt-3 ml-3">
                    @yield('header')
                </div>
            </header>

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>

        {{-- @stack('modals') --}}
        {{-- @livewireScripts --}}


        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        @yield('page-js')
        <script src="{{asset('js/main.js')}}"></script>
    </body>
</html>
