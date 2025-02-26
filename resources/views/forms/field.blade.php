@php
    $text = !empty($text) ? $text : __('messages.create_land_btn');
    can_call_fun(debug_logs($prop));

    $id = $prop[config('vars.id')] ?? 'c_password';
    $include_star = $prop[config('vars.include_star')] ?? true;
    $label = $prop[config('vars.label')] ?? '';
    $form_type = $prop['type'] ?? 'text';
    $value = $prop[config('vars.value')] ?? '';
    $placeholder = $prop['placeholder'] ?? $label;

@endphp
<label for="{{ $id }}" class="@if($form_type == 'hidden')hidden @endif">
    {{ $label }}@if ($include_star)
        {!! config('setting.red_star') !!}
    @endif
</label>
<input type="{{ $form_type }}" name="{{ $id }}" id="{{ $id }}" placeholder="{{ $placeholder }}"
    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $value ?? '' }}" />
