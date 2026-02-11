@extends("layouts.guest")

@section('content')
    @include('loader')
    @include('session_msg')
    @include('home_page')

    @include('show_courses')

    @include('components.categories')

    @include('posts')
    @include('instructor')
    @include('faqs')
@endsection

@section('script')
    @if (config('setting.aos_js'))
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
    @endif
@endsection
