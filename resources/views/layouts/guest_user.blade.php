@php
    use Illuminate\Support\Facades\Cache;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    @include('layouts.seo')
    @include('css_js_lib')
    
    @yield('page-css')
</head>

<body style="min-height: 100vh !important" class="d-flex flex-column ">

    @if (!Cache::store('file')->get('isLoaderLoaded'))
        {{-- prettier-ignore --}}
        {!! view("loader_html")->render() !!}
        {{-- prettier-ignore-end --}}

        @php Cache::store('file')->put('isLoaderLoaded', true, 3600); @endphp
    @endif

    @include('ann')
    @include('nav')
    <!-- main Content -->
    <main>
        @yield('content')
    </main>

    @yield('script')
</body>

</html>
