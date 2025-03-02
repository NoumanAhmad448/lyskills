@if (config('setting.en_im_event'))
    <div class="w-full-sm container pt-14 sm:mt-10 mx-auto">
        <h2 class="{!! config('setting.h2_css') !!}">
            {{ __('messages.event') }}
        </h2>
        @if ($data && $data['features'])
            <div class="w-full-sm md:flex md:flex-wrap md:justify-between md:items-center">
                @if (count($data['features']) > 0)
                    @foreach ($data['features'] as $feature)
                        <div class="w-full-sm py-4 rounded max-w-sm overflow-hidden shadow-lg pr-10">
                            <img class="w-full" src="{{ $feature['img'] }}" alt="{{ $feature['alt'] }}">
                            <div class="px-6 py-4">
                                <div class="font-bold text-xl mb-2">{{ $feature['title'] }}</div>
                                <p class="text-gray-700 text-base">{!! $feature['title_desc'] !!}
                                </p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        @endif
    </div>
@endif
