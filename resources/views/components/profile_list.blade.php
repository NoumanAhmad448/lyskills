@php
$link = $prop["link"] ?? "profile.html";
$svg = $prop["svg"] ?? config('files.svg')."profile";
$text = $prop["text"] ?? __("messages.mprofile");
@endphp
<li>
    <a href="{{$link}}"
        class="py-2
            flex items-center gap-3.5 text-sm font-medium duration-300 ease-in-out lg:text-base">
        @if($svg)
            @include($svg)
        @endif
        {{$text}}
    </a>
</li>