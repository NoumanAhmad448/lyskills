<div class="container-fluid">
    @include('sn.load_container')
    <div class="content-main jumbotron bg-website text-white my-2 text-center">
        <h2>{{ __('homepage.instructor.title') }}</h2>
        <div class="my-1">
            {{ __('homepage.instructor.description') }}
        </div>
        <a href="{{ route('instructor.register') }}" class="btn btn-website border">
            {{ __('homepage.instructor.cta') }}
        </a>
    </div>
</div>
