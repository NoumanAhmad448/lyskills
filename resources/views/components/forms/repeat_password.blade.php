@php
    $text = !empty($text) ? $text : __('messages.create_land_btn');
    $id = $prop['id'] ?? config("form.c_password");
    $include_star = $include_star ?? true;

@endphp
<label for="{{$id}}">
    {{ __('messages.re_password') }}@if ($include_star)
        {!! config('setting.red_star') !!}
    @endif
</label>
<input type="password" name="{{$id}}" id="{{$id}}" placeholder="{{ __('messages.re_password') }}"
    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $c_password ?? '' }}" />
