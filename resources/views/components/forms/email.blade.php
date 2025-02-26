@php
    $include_star = $include_star ?? true;
    $is_form = $is_form ?? true;
@endphp

@if ($is_form)
    <label for="{{ config('form.email') }}">
        {{ __('messages.EmailAddress') }}@if ($include_star)
            {!! config('setting.red_star') !!}
        @endif
    </label>
    <input type="email" name="{{ config('form.email') }}" id="{{ config('form.email') }}"
        placeholder="{{ __('label.EmailAddressSample') }}" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
        value="{{ $email ?? '' }}" />
@else
    <label for="{{ config('form.email') }}" class="mb-2.5 block font-medium text-black dark:text-white">
        {{ __('label.EmailAddress') }}</label>
    <div class="relative">
        <input type="email" placeholder="{{ __('label.EmailAddressSample') }}"
            name="{{ config('form.email') }}" id="{{ config('form.email') }}"
            class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />

        <span class="absolute right-4 top-4">
            @include(config("files.components").'.email_svg')
        </span>
    </div>

@endif
