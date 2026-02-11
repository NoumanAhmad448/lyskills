@php $ex_youtube_res = $m_lec->ex_res; @endphp
@if ($ex_youtube_res && $ex_youtube_res->title)
    <div class="my-5">
        <div class="container">
            <h3 class="mb-4"> Extra Resource That might help </h3>
            <div> {{ $ex_youtube_res->title }} </div>
            <iframe class="w-100" height="300" src="{{ $ex_youtube_res->link }}" title="YouTube video player"
                frameborder="0" allow="accelerometer;  clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
        </div>
    </div>
@endif
