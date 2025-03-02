@php
    $include_star = $include_star ?? true;
@endphp
<label for="city">City @if ($include_star)
    {!! config('setting.red_star') !!}
@endif</label>
<input type="text" name="city" id="city" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value=""
    placeholder="" />
