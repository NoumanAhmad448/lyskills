<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.seo')
    @include('lib.custom_lib')
    @yield('page-css')
</head>

<body style="min-height: 100vh !important" class="d-flex flex-column ">
    @include('modals.modal')
    @include('ann')
    @if (config('setting.guest_header'))
        @include('nav')
    @endif

    <!-- main Content -->
    <main>
        @yield('content')
    </main>
    
    @if (config('setting.guest_footer'))
        @include('footer')
    @endif
</body>

</html>
