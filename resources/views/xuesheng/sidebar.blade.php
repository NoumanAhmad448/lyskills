@php
    use App\Models\Lecture;
@endphp
@if ($sections)
    @foreach ($sections as $sec)
        <ul class="ml-4 mt-2 list-group">
            <h4 class="text-capitalize font-bold mb-4"> {{ $sec->section_title ?? '' }} </h4>
            {{-- prettier-ignore --}}

                           @php
            $lectures = Lecture::where([
            ['course_id', $course->id],
            ['sec_no', '=', $sec->section_no],
            ])->get();
            @endphp
            {{-- prettier-ignore-end --}}

            @if ($lectures->count())
                @foreach ($lectures as $lec)
                    @php $video = $lec->media; @endphp

                    @if ($video && $video->lec_name && $video->lec_name[1])
                        <li
                            class=" list-group-item mt-2 py-2 pl-3 @if ($video->id === $media->id) bg-static-website @endif">
                            <section class="d-flex justify-content-between">
                                <a class="text-capitalize d-block @if ($video->id === $media->id) text-white @endif"
                                    href="{{ route('video-page', ['slug' => $course->slug, 'video' => explode('/', $video->lec_name)[1]]) }}">
                                    <i class="fa fa-play mr-2"
                                        aria-hidden="true"></i>{{ reduceCharIfAv($lec->lec_name ?? '', 40) }}
                                </a>
                                <span class="mr-1"> {{ $formatter->format($video->duration) }} </span>
                            </section>
                        </li>
                    @endif
                @endforeach
            @endif
        </ul>
    @endforeach
@endif
@if ($course->course_title)
    <a href="{{ route('down-cert', ['course_name' => $course?->course_title]) }}"
        class="btn btn-website btn-lg mt-5 ml-4" target="_blank" style="width: 230px">
        Get Your Certificate
    </a>
    <a title="Commenting on course will show the detail in course page"
        href="{{ route('laoshi-comment', ['course_name' => $course?->slug]) }}" class="btn btn-website btn-lg mt-2 ml-4"
        target="_blank" style="width: 230px">
        <img src="https://media.giphy.com/media/LHZyixOnHwDDy/giphy.gif" alt="nothing" width="50" height="50">
        <br />Comment on Course
    </a>
@endif
