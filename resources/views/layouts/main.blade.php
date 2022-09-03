<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title> {{ __('messages.blogger_login') }} </title>
        <meta name="description" content="{{ __('description.default') }}">
        <meta property="og:title" content=" {{ trans('messages.blogger_login') }}">
        <meta property="og:description" content="{{ __('description.default') }}">
        <link rel="canonical" href="{{ url()->current() }}">
        <link rel="shortcut icon" href="{{asset('img/favicon.png')}}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&amp;display=swap" rel="stylesheet">

        

        <!-- bootstrap 4.5.3 -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        
        @livewireStyles        
        
        <!-- font awesome  -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        @yield('page-css')
    </head>
    <body style="font-family: roboto;">
        
        {{ $slot }}

        
        @livewireScripts


        <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ="
         crossorigin="anonymous"></script>
        @yield('page-js')
    </body>
</html>
