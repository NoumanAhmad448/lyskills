@php

    $title = $title ?? __('messages.land_registeration');
    $desc = $desc ?? __('messages.wel_desc');
    debug_logs($land);
@endphp
<div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3 my-4">
    <div class="text-gray-600">
        <p class="font-medium text-lg">{{ $title }}</p>
        <p>{{ $desc }}</p>
    </div>

    <div class="lg:col-span-2">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
            @if(!empty($land))
                @include(config("files.components_").'form_type', [
                    config("vars.method") => "PATCH",
                ])
            @endif
            @include(config("files.forms").'col', ['input' => config("files.forms").'field',
            config("vars.prop") => [config('vars.id') => config("setting.title"), config('vars.label') => __("messages.land_title"),
            config('vars.value') => $land ? $land?->title : ''
            ]])
            @include(config("files.forms").'col', ['input' => config("files.forms").'field',
            config("vars.prop") => [config('vars.id') => config("setting.description"), config('vars.label') => __("messages.land_des"),
            config('vars.value') => $land ? $land?->description : ''
            ]])
            @include(config("files.forms").'col', ['input' => config("files.forms").'field',
            config("vars.prop") => [config('vars.id') => config("setting.location"), config('vars.label') => __("messages.location_desc"),
            config('vars.value') => $land ? $land?->location : ''

            ]])
            @include(config("files.forms").'col', ['input' => config("files.forms").'field',
            config("vars.prop") => [config('vars.id') => config("setting.size"), config('vars.label') => __("messages.size_desc"),
            config('vars.value') => $land ? $land?->size : ''
            ]])
            @include(config("files.forms").'col', ['input' => config("files.forms").'dropdown',
            "col" => 3 , config("vars.prop") => [config('vars.id') => config("setting.city"), config('vars.label') => __("messages.city_desc"),
            config('vars.show_value') => $land ? $land?->city?->id : '',
            config('vars.value') => $land ? $land?->city?->name : '',
            ]])
            @if(config("setting.en_country"))
                @include(config("files.forms").'col', ['input' => config("files.forms").'dropdown',
                "col" => 2 , config("vars.prop") => ["col" => 2,config('vars.id') => config("setting.country"),
                config('vars.label') => __("messages.country_desc"),
                ]])
            @endif
            @if(config("setting.en_land_reg_file"))
                @include(config("files.forms").'col', ['input' => config("files.forms").'file',
                 config("vars.prop") => ["col" => 2,config('vars.id') => config("setting.land_reg_file_upload"),
                 "include_star" => false, config('vars.label') => __("messages.file_upload_desc"),
                 "is_multiple" => config("setting.landreg_multiple"),
                 config("vars.files") => $land ? $land?->landFiles : ''
                ]])
            @endif
            @if(config("setting.en_gc"))
                @include(config("files.forms").'col', ['input' => config("files.forms").'captcha',
                 ])
            @endif
        </div>
    </div>
</div>
