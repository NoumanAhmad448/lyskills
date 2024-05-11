@if ($course->user && $course->user->profile_photo_path)
    @if (!config('setting.store_img_s3'))
        {{ asset($course->user->profile_photo_path) }}
    @else
        {{ config('setting.s3Url') }}{{ Auth::user()->profile_photo_path }}
    @endif
@else
    {{ $course->user() ? $course->user()->profile_photo_url : '' }}
@endif
