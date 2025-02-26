@php
    $extra_atrr = $extra_atrr;
@endphp
@if ($extra_atrr && count($extra_atrr))
    @foreach ($extra_atrr as $attr => $value)
        {{ $attr }} = {{ $value }}
    @endforeach
@endif
