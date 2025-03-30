@if ($errors->any())
    <div {{ $attributes }} class="border-top">
        <div class="font-medium text-danger text-bold">{{ __('Whoops! Something went wrong.') }}</div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600 text-danger border-bottom">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
