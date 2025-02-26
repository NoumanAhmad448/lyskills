@php
    $id = $prop["id"] ?? 'billing_same';
    $is_array = $prop["is_array"] ?? true; // pass an array to the server
    $text = $prop['text'] ?? '';
    $show_label = $prop["show_label"] ?? false;
    $classes = $prop["classes"] ?? '';
    $value = $prop["value"] ?? "";
@endphp

<div class="flex items-center mb-4">
    <input type="checkbox" name="{{ $id }}@if($is_array)[]@endif" id="{{ $id }}@if($is_array)[]@endif"
    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500
     dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600
     {{$classes}}
     "
     value="{{$value}}"
    />
    @if($show_label)
        <label for="{{ $id }}" class="ml-2">{!! $text !!}</label>
    @endif
</div>
