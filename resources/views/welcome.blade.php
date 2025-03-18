@extends(config('setting.guest_blade'))

@section('content')
    {{-- <section class="d-flex justify-content-center align-items-center loading-section">
    <div id="loading" class="spinner-border text-info text-center" style="width: 90px; height: 90px" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</section> --}}
    @include('session_msg')
    @if (config('setting.homepage_image'))
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    @include('sn.load_img')
                    <section style="position: relative" class="content-main">
                        <img src="{{ $settings && $settings->homepage_photo ? config('setting.s3Url') . $settings->homepage_photo : asset('img/student.jpg') }}"
                            alt="{{ __('homepage.alt_text.student') }}" class="img-fluid mx-auto d-block" id="student_img"
                            style="box-shadow: 0px 10px 10px 3px #605f5b;" />
                        <a href="{{ route('register') }}" class="btn btn-outline-website d-none"
                            style="position: absolute; top: 0;left: 0;">
                            {{ __('homepage.buttons.instructor') }}
                        </a>
                    </section>
                </div>
            </div>
        </div>
    @endif

    @include('show_courses')

    @include('components.categories')

    @if (config('setting.all_posts'))
        @if (isset($post) && $post)
            <div class="container-fluid">
                <div class="row">
                    @include('sn.load_img')
                    <div class="col-md-12 content-main">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('all_public_posts') }}"
                                class="btn btn-lg btn-website">{{ __('homepage.posts.all') }}</a>
                        </div>
                    </div>
                    @include('sn.load_container')
                    <div class="col-md-8 offset-md-2 content-main">
                        <h2 class="my-2">{{ __('homepage.posts.recent') }}</h2>
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <img src="{{ config('setting.s3Url') . $post->upload_img }}" alt="{{ $post->f_name ?? '' }}"
                                    class="img-fluid" />
                            </div>
                        </div>
                        <h3 class="text-center mt-2 text-uppercase">
                            {{ $post->title }}
                        </h3>
                        <div class="mt-2">
                            {!! reduceWithStripping($post->message, 300) !!}
                        </div>
                        <a href="{{ route('public_posts', ['slug' => $post->slug]) }}"
                            class="btn btn-website my-2 float-right">{{ __('homepage.posts.read_more') }}</a>
                    </div>
                </div>
            </div>
        @endif
    @endif
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
    @if (config('setting.all_faqs'))
        @if (isset($faq) && $faq)
            <div class="container-fluid my-3">
                <div class="row">
                    <div class="col-md-12">
                        @include('sn.load_container')
                        <div class="d-flex justify-content-end content-main">
                            <a href="{{ route('public_faq') }}"
                                class="btn btn-lg btn-website">{{ __('homepage.faq.all') }}</a>
                        </div>
                    </div>
                    <div class="col-md-8 offset-md-2">
                        @include('sn.load_container')
                        <section class="content-main">
                            <h2 class="my-2">{{ __('homepage.faq.recent') }}</h2>
                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <img src="{{ config('setting.s3Url') . $faq->upload_img }}"
                                        alt="{{ $faq->f_name ?? '' }}" class="img-fluid" />
                                </div>
                            </div>
                            <h3 class="text-center mt-2 text-uppercase">
                                {{ $faq->title }}
                            </h3>
                            <div class="mt-2">
                                {!! reduceWithStripping($faq->message, 300) !!}
                            </div>
                            <a href="{{ route('public_faqs', ['slug' => $faq->slug]) }}"
                                class="btn btn-website my-2 float-right">
                                {{ __('homepage.faq.read_more') }}
                            </a>
                        </section>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endsection

@section('script')
    @if (config('setting.aos_js'))
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
    @endif
@endsection
