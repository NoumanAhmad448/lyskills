@php
    $text = !empty($text) ? $text : __('messages.create_land_btn');
    $id = $prop['id'] ?? config('form.password');
    $include_star = $include_star ?? true;
    $is_form = $is_form ?? true;

@endphp
@if ($is_form)

<label for="{{ $id }}">
    {{ __('messages.password') }}@if ($include_star)
        {!! config('setting.red_star') !!}
    @endif
</label>
<input autocomplete="off" type="password" name="{{ $id }}" id="{{ $id }}" placeholder="{{ __('messages.password') }}"
    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $password ?? '' }}" />
@else

<label class="mb-2.5 block font-medium text-black dark:text-white">
    {{ __('messages.password') }}
</label>
<div class="relative">
    <input type="password" placeholder="{{ __('messages.password') }}"
        name="{{ $id }}" id="{{ $id }}"
        class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />

    <span class="absolute right-4 top-4">
        @include(config("files.components_").'pass_svg')
    </span>
</div>
@endif