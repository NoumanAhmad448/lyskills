@php $other_file = $m_lec->other_file; @endphp
@if ($other_file)
    <div class="my-5">
        <div class="container">
            <h3 class="mb-2">
                Recommended Material to read offline
            </h3>
            <a href="{{ asset('storage/' . $other_file->f_path) }}" download="download" class="btn btn-website mt-2">
                {{ $other_file->f_name }}
            </a>
        </div>
    </div>
@endif
@if ($next_media)
    <div class="d-flex justify-content-end my-2">
        <a href="{{ route('video-page', ['slug' => $course->slug, 'video' => explode('/', $next_media->lec_name)[1]]) }}"
            class="btn btn-lg btn-website"> Next </a>
    </div>
@endif
