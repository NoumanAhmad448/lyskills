@php

    $title = $title ?? __('messages.PersonalDetails');
    $desc = $desc ?? __('messages.PersonalDetails_desc');
@endphp
<div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3 my-4">
    <div class="text-gray-600">
        <p class="font-medium text-lg">{{ $title }}</p>
        <p>{{ $desc }}</p>
    </div>

    <div class="lg:col-span-2">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
            @include(config("files.forms").'three_col', ['input' => config("files.forms").'firstname'])
            @include(config("files.forms").'two_col', ['input' => config("files.forms").'lastname'])
            @include(config("files.forms").'five_col', ['input' => config("files.forms").'email'])

            @include(config("files.forms").'three_col', [
                'input' => config("files.forms").'password',
                "prop" => [
                    "id" => config('form.password'),
                ],
                ])
            @include(config("files.forms").'two_col', [
                'input' => config("files.forms").'repeat_password'
                ,
                "prop" => [
                    "id" => config('form.c_password'),
                ],
                ])
        </div>
    </div>
</div>
