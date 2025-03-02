@php
$include_star = $include_star ?? true;
@endphp

<div class="md:col-span-2">
    <label for="{{config("form.lastname")}}">{{ __("label.LastName")}}@if($include_star){!! config('setting.red_star') !!}@endif</label>
    <input type="text" name="{{config("form.lastname")}}" id="{{config("form.lastname")}}"
    placeholder="{{ __("messages.LastName")}}"
        class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{$lastname ?? ''}}" />
</div>