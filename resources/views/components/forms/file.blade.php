@php

$text = !empty($text) ? $text : __('messages.create_land_btn');

$id = $prop['id'] ?? 'c_password';
$include_star = $prop['include_star'] ?? true;
$label = $prop['label'] ?? '';
$value = $prop['value'] ?? '';
$col = $prop['col'] ?? 3;
$data = $prop["data"] ?? "";
// by default pick the column name from the table
$message = $prop["message"] ?? __("messages.file_upload_msg");
$input_title = $prop["input_title"] ?? __("messages.file_upload_title");
$is_multiple = $prop["is_multiple"] ?? false;
$files = $prop[config("vars.files")] ?? false;
@endphp
@include(config("files.components").".loader", ["prop" => [
    "id" => $id
]])
<label><span class="mr-2 mb-2">{{$label}}</span></label>
@if ($include_star)
    {!! config('setting.red_star') !!}
@endif
<div class="flex items-center justify-center w-full">
    <label for="{{$id}}"
        class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
        <div class="flex flex-col items-center justify-center pt-5 pb-6">
            @include(config("files.components").".file_upload")
            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                {!!$input_title!!}
            </p>
            <p class="text-xs text-gray-500 dark:text-gray-400">{!! $message !!}</p>
        </div>
        <input name="{{$id}}@if($is_multiple)[]@endif" id="{{$id}}" type="file" class="hidden" onchange="showImage(this, 'image{{$id}}')"
        @if($is_multiple) multiple @endif
        />
    </label>
</div>
@include(config("files.components").".loader_script", ["prop" => ['id' => $id]])
<section class="image{{$id}} flex items-center justify-center mt-5">
    @if($files)
        @foreach($files as $file)
            <img
            id='img{{$file?->id}}'
            src='{{ file_path($file->link) }}' width="150" height="150" class="pr-4 rounded-lg
            transition-all duration-300 cursor-pointer
            h-auto max-w-lg
            "/>
        @endforeach
    @endif
</section>