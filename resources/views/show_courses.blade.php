<?php
use App\Models\RatingModal;

?>
@if (config('setting.show_courses_main_page'))
    @if ($courses && $courses->count())
        <div class="container-fluid my-5">
            @if (config('setting.main_courses_heading'))
                <h2>{{ __('homepage.courses.available') }}</h2>
            @endif
            <div class="d-flex justify-content-end">
                @include('sn.load_btn')
                <a href="{{ route('show-all-courses') }}"
                    class="btn btn-website content-main btn-lg">{{ __('homepage.courses.all') }}</a>
            </div>
            <div class="row mt-2 row-cols-md-5">
                @foreach ($courses as $course)
                    <div class="col-12 col-md mt-2">
                        @include('sn.load_card')
                        @if ($course?->slug)
                            <div class="content-main card fix-height" style="box-shadow: 0px 1px 1px 1px #bbb8af;">
                                <a href="{{ route('user-course', ['slug' => $course?->slug]) }}">
                                    @if ($course?->course_image)
                                        <img class="card-img-top img-fluid"
                                            src="{{ config('setting.s3Url') . $course?->course_image?->image_path }}"
                                            alt="{{ $course?->course_image?->image_name }}">
                                    @endif
                                </a>

                                @php
                                    $rating_avg = (float) RatingModal::where('course_id', $course?->id)?->avg('rating');
                                    $rated_by_students = (int) RatingModal::where('course_id', $course?->id)?->count(
                                        'rating',
                                    );
                                @endphp

                                {{-- <div class="card-body" style="/height: 180px"> --}}
                                <div class="card-body" style="height: 150px">
                                    <h5 class="card-title font-bold text-capitalize"
                                        style="font-size: 1.1rem;font-weight:bold">
                                        {{ reduceCharIfAv($course?->course_title ?? '', 40) }}
                                    </h5>
                                    <a href="{{ route('user-course', $course?->slug ?? '') }}#profile"
                                        class="card-text text-capitalize mb-0 mt-1"><span class="">
                                            {{ reduceWithStripping($course?->user?->name ?? 0, 20) ?? '' }} </span>
                                    </a>
                                    <p
                                        class="mb-0 mt-1 @if ($course?->categories_selection == 'it') {{ 'text-uppercase' }} @else {{ 'text-capitalize' }} @endif">
                                        {{ reduceWithStripping($course?->categories_selection, 20) ?? '' }} </p>
                                    @if ($rating_avg)
                                        <div class="d-flex align-items-center">
                                            <section id="rating" class="d-flex align-items-center"
                                                style="cursor: pointer">
                                                ({{ round($rating_avg, 2) }})
                                                <span
                                                    class="fa fa-star  @if ($rating_avg >= 1) {{ 'text-warning' }} @endif"
                                                    no="1"></span>
                                                <span
                                                    class="fa fa-star ml-1  @if ($rating_avg >= 2) {{ 'text-warning' }} @endif"
                                                    style="text-size: 1.3rem;" no="2"></span>
                                                <span
                                                    class="fa fa-star ml-1  @if ($rating_avg >= 3) {{ 'text-warning' }} @endif"
                                                    style="text-size: 1.3rem;" no="3"></span>
                                                <span
                                                    class="fa fa-star ml-1  @if ($rating_avg >= 4) {{ 'text-warning' }} @endif"
                                                    style="text-size: 1.3rem;" no="4"></span>
                                                <span
                                                    class="fa fa-star ml-1  @if ($rating_avg >= 5) {{ 'text-warning' }} @endif"
                                                    style="text-size: 1.3rem;" no="5"></span>
                                                <span class="ml-1">( {{ $rated_by_students }} )</span>
                                            </section>
                                        </div>
                                    @endif
                                    <p class="card-text text-capitalize  mb-0  mt-1 d-flex font-bold">
                                        @if ($course?->price?->is_free)
                                            {{ __('homepage.courses.free') }}
                                        @else
                                            <span style="font-weight:bold"> ${{ $course?->price?->pricing ?? '' }}
                                            </span>
                                            @php $total_p = ((int)$course?->price?->pricing)+20 @endphp
                                            <del class="ml-2"> ${{ $total_p }} </del>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-end my-3">
                @include('sn.load_btn')
                <a href="{{ route('show-all-courses') }}"
                    class="btn btn-website content-main btn-lg">{{ __('homepage.courses.next') }}</a>
            </div>
        </div>
    @endif
@endif
