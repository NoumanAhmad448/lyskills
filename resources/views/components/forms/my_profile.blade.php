@php

    $title = $title ?? __('messages.PersonalDetails');
    $desc = $desc ?? __('messages.PersonalDetails_desc');
    $user = $data[config("vars.user")] ?? "";
    debug_logs($user);
@endphp
<div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3 my-4">
    <div class="text-gray-600">
        <p class="font-medium text-lg">{{ $title }}</p>
        <p>{{ $desc }}</p>
    </div>

    <div class="lg:col-span-2">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
            @include(config("files.forms").'col', [
                config("vars.input") => config("files.forms").'field',
                config("vars.prop") => [
                    config('vars.id') => config("table.name"),
                    config('vars.label') => __("label.flnme"),
                    config('vars.value') => $user?->name,
                ]
            ])
            @include(config("files.forms").'col', [
                config("vars.col") => 2,
                config("vars.input") => config("files.forms").'field',
                config("vars.prop") => [
                    config('vars.id') => config("table.age"),
                    config('vars.label') => __("label.age"),
                    config('vars.include_star') => false,
                    config('vars.value') => $user?->userProfile?->age,
                ]
            ])
            @include(config("files.forms").'col', [
                config("vars.col") => 3,
                config("vars.input") => config("files.forms").'field',
                config("vars.prop") => [
                    config('vars.id') => config("table.mobile"),
                    config('vars.label') => __("label.mble_no"),
                    config('vars.include_star') => false,
                    config('vars.value') => $user?->userProfile?->mobile,
                ]
            ])
            @include(config("files.forms").'col', [
                config("vars.input") => config("files.forms").'dropdown',
                config("vars.col") => 2 , config("vars.prop") =>
                    [
                        config('vars.id') => config("table.gender"),
                        config('vars.label') => __("label.gender"),
                        config('vars.include_star') => false,
                        config('vars.show_value') => $user?->userProfile?->gender,
                        config('vars.value') => $user?->userProfile?->gender,

                    ]])
            @include(config("files.forms").'col', [
                config("vars.input") => config("files.forms").'dropdown',
                config("vars.col") => 3 , config("vars.prop") =>
                    [
                        config('vars.id') => config("table.job_id"),
                        config('vars.label') => __("label.jobs"),
                        config('vars.include_star') => false,
                        config('vars.key') => config('vars.title'),
                        config('vars.show_value') => $user?->userProfile?->job_id,
                        config('vars.value') => $user?->userProfile?->job?->title,
            ]])
            @include(config("files.forms").'col', [
                config("vars.input") => config("files.forms").'field',
                config("vars.prop") => [
                    config('vars.include_star') => false,
                    config('vars.id') => config("table.address"),
                    config('vars.label') => __("label.location_desc"),
                    config('vars.value') => $user?->userProfile?->address,
                ]
            ])
        </div>
    </div>
</div>

