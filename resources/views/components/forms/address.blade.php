@php
    $include_star = $include_star ?? true;
@endphp
<label for="address">Address / Street @if ($include_star)
        {!! config('setting.red_star') !!}
    @endif
</label>
<input type="text" name="address" id="address" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
    value="{{ $address ?? '' }}" placeholder="s" />
