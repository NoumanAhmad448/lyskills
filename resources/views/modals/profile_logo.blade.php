@if (Auth::user()->profile_photo_path && !config('setting.store_img_s3'))
    {{ asset(Auth::user()->profile_photo_path) }}
@elseif(config('setting.store_img_s3'))
    {{ config('setting.s3Url') }}{{ Auth::user()->profile_photo_path }}
@else
    {{ Auth::user()->profile_photo_url }}
@endif
