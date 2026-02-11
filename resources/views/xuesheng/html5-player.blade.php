<video controls class="w-100" oncontextmenu="return false;" preload="auto">
    {{-- <source src="http://lyskills-by-us-yes-that-us.s3.ap-south-1.amazonaws.com/uploads/uTxkkvjjh09Xs7a4Gohy37hnV55ZA8zQcpt2Qxsm.mp4" --}}
    <source src="{{ config('setting.s3Url') }}{{ $media->lec_name }}" type="{{ $extra_vid->f_mimetype ?? '' }}">
    {{ __('video_nt_fnd') }}
</video>
