@if (Auth::user() && Auth::user()->profile_photo_path)
    @if(!config('setting.store_img_s3'))
        {{ asset(Auth::user()->profile_photo_path) }}
    @elseif(config('setting.store_img_s3'))
        {{ config('setting.s3Url') }}{{ Auth::user()->profile_photo_path }}
    @endif
@else
    {{ Auth::user() && Auth::user()->profile_photo_url ? Auth::user()->profile_photo_url: ''}}
@endif
