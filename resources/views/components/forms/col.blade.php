@php
$move_btn_right = $move_btn_right ?? false;
$col = $col ?? 5;
$prop = $prop ?? ""
@endphp
<div class="md:col-span-{{$col}} @if($move_btn_right) {{ 'text-right' }} @endif">
    @include($input, ["text" => $text ?? '', "prop" => $prop ])
</div>
