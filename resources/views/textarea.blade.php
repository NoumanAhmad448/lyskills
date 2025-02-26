@php
    $text = !empty($text) ? $text : "";
    $placeholder= $prop["placeholder"] ?? "Write your thoughts here...";
    $label= $prop["label"] ?? __("messages.lnd_msg_txtara_lbl");
    $id = $id ?? 'submit';
    $classes = $classes ?? '';
    $extra_atrr = $extra_atrr ?? '';
@endphp

<label for="{{$id}}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
    {{$label}}</label>
<textarea id="{{$id}}" name="{{$id}}" rows="4"
    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500
    {{$classes}}
    "
    @include(config("files.forms").'extra_attr', ["extra_atrr" => $extra_atrr])
    placeholder="{{$placeholder}}">{{$text}}</textarea>
