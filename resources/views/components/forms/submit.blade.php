@php
$text = !empty($text) ? $text : __("messages.create_land_btn");
$id = $id ?? "submit";
$classes = $classes ?? "";
$is_btn = $is_btn ?? "submit";
$extra_atrr = $extra_atrr ?? "";
@endphp

<div class="inline-flex items-end {{$classes}}">
    <button type="{{$is_btn}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
    id={{$id}}
    @include(config("files.forms").'extra_attr', ["extra_atrr" => $extra_atrr])
    >
        @include(config("files.components").".right_arrow"){!! $text !!}
    </button>
</div>
