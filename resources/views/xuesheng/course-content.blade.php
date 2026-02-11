@php
use App\Models\Lecture;
use App\Models\Media;
$formatter = app(\App\Classes\Contracts\TimeFormatterInterface::class);
@endphp
@extends(config('setting.guest_blade'))

@section('page-css')
    <style>
        .rating:hover {
            color: #ffc107 !important;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="container-fluid mb-5">
        {{-- top navbar --}}
        @include('xuesheng.navbar')
        <div class="d-md-none" id="menu">
            <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
        </div>
        <div class="row">
            <div class="col-md-3 border p-2 d-none d-md-block" id="list">
                @php isset($course) ? $sections = $course->sections : abort(500); @endphp
                {{-- sidebar --}}
                @include("xuesheng.sidebar")
            </div>
            <div class="col-md-9">
                @php
                    $id = $media->lecture_id;
                    $course_id = $media->course_id;
                    $next_media = Media::where('lecture_id', $id + 1)
                        ->where('course_id', $course_id)
                        ->first();
                @endphp
                @if ($next_media)
                    <div class="d-flex justify-content-end my-2">
                        <a href="{{ route('video-page', ['slug' => $course->slug, 'video' => explode('/', $next_media->lec_name)[1]]) }}"
                            class="btn btn-lg btn-website"> Next </a>
                    </div>
                @endif
                
                {{-- xuesheng.html5-player | xuesheng.media-player --}}
                @include(app('mediaPlayerView'))
                <div class="my-5">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <h3> About Course </h3>
                                <div class="pl-3 mt-2">
                                    <h4 class="text-capitalize my-2"> {{ $course->course_title ?? '' }} </h4>
                                    <div class="my-2"> {{ $course->categoires_selection ?? '' }} </div>
                                    <div class="my-2"> {!! $course->description ?? '' !!} </div>
                                    <div class="my-2">{{ $course->c_level ?? '' }} </div>
                                    <div class="my-2"> <a href="{{ route('user-course', ['slug' => $course->slug]) }}"
                                            class="btn btn-website"> Course Link </a> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('xuesheng.ann')             
                @include('xuesheng.video')
                @include('xuesheng.extra_recom')
                @include('xuesheng.recom_article')
                @include('xuesheng.extra')
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <script>
        let rating_url = "{{ route('rating-course') }}";
        let course_slug = '{{ $course->slug }}';
    </script>
    <script src="{{ asset('js/course-content.js') }}"></script>
@endsection
