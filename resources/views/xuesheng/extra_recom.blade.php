@php $extra_vid = $m_lec->res_vid; @endphp
@if ($extra_vid)
    <div class="my-5">
        <div class="container">
            <h3 class="mb-2">
                Extra Recommended Video
            </h3>
            @if ($should_usr_hv_acs)
                <video controls class="w-100" oncontextmenu="return false;" preload="auto">
                    <source src="{{ config('setting.s3Url') }}{{ $extra_vid->lec_path }}"
                        type="{{ $extra_vid->f_mimetype ?? '' }}">
                    {{ __('video_nt_fnd') }}
                </video>
            @else
                {{ __('access_restricted') }} {{ dateFormat($media?->access_duration) }}
            @endif
        </div>
    </div>
@endif
