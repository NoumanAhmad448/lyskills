<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @if (isset($title))
            {{ __('messages.' . $title) }}
        @else
            {{ __('messages.admin') }}
        @endif
    </title>
    <meta name="description"
        content="@if (isset($desc)) {{ $desc }} @else {{ __('description.default') }} @endif">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    @include('lib.custom_lib')

    @yield('page-css')
</head>

<body class="d-flex flex-column" style="min-height: 90%">
    <nav class="navbar bg-website" style="flex: 1">
        @if (config('setting.show_site_log'))
            <a class="navbar-brand text-white" href="{{ route('a_home') }}">
                Lyskills
            </a>
        @endif
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('index') }}" target="_blank">
                    <i class="fa fa-home" aria-hidden="true"></i> Home </a>
            </li>
        </ul>
        @if (config('setting.login_profile'))
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('a_logout') }}">
                        <i class="fa fa-sign-out" aria-hidden="true"></i> Logout </a>
                </li>
            </ul>
        @endif
    </nav>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-3">
                <i class="fa fa-bars d-md-none" aria-hidden="true" id="hamburger"></i>
                <ul class="nav flex-column d-none d-md-block border-right" id="side_menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('health') }}">
                            <i class="fa fa-home" aria-hidden="true"></i> Health
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('deleteProject') }}">
                            <i class="fa fa-home" aria-hidden="true"></i> Delete Project
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dev.get.cron_jobs') }}">
                            <i class="fa fa-home" aria-hidden="true"></i> Cron Jobs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dev.syncSchedule') }}">
                            <i class="fa fa-home" aria-hidden="true"></i> Scheduled Cron Jobs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/dev/telescope">
                            <i class="fa fa-home" aria-hidden="true"></i> telescope
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-md-9">
                @yield('content')
            </div>
        </div>
    </div>

    @yield('footer')
