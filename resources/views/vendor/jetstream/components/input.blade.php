@props(['disabled' => false])

{{-- <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control form-input rounded-md shadow-sm']) !!}> --}}
<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control']) !!}>
