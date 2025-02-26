@php
    $status_pad = $prop['status_pad'] ?? '';
    $svg_w = $prop['width'] ?? 'w-8';
    $svg_h = $prop['h'] ?? 'h-8';
    $id = $prop["id"] ?? '';
    debug_logs("inside loader component");
    debug_logs($prop);

@endphp
@if($id)
<section class="{{ $id }}loader">
    @include(config('files.svg') . 'loader', ["prop" => $prop])
</section>
@endif
