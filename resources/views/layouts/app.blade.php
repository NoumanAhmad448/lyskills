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
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

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
        <div class="min-h-screen">
            @livewire('navigation-dropdown')

            <!-- Page Heading -->
            <header class="bg-white">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @yield('header')
                </div>
            </header>

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>

        {{-- @stack('modals') --}}

        @livewireScripts


        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        @yield('page-js')
    </body>
</html>
