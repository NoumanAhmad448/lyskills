@if (config('setting.en_mo_info_con'))
    <div class="container text-center pt-14">
        <h2 class="section-heading">{{ __('messages.mo_info') }}</h2>
        @if (config('setting.en_im_glass'))
            <div class="relative mt-10 mb-14 bg-cover rounded-xl py-24 bg-center"
                style="background-image: url({{ url(config('setting.im_glass')) }}">
                <div class="absolute w-full h-full rounded-xl opacity-50 bg-black left-0 top-0"></div>
                <div class="relative z-20">
                    <h2
                        class="text-white mb-4 text-4xl font-extrabold leading-none tracking-tight md:text-5xl lg:text-6xl dark:text-white">
                        {{ __('messages.get_in') }}
                    </h2>
                    <p class="px-2 text-white text-xl flex flex-col justify-center items-center">
                        {{ __('messages.getting_invol') }}
                        </a>
                </div>
            </div>
        @endif

        @if (config('setting.en_newsupdates'))
            <div class="text-xl">
                <h2
                    class="flex flex-col justify-center items-center mb-4 text-4xl font-extrabold leading-none
                        tracking-tight md:text-5xl lg:text-6xl dark:text-white">
                    {{ __('messages.NewsUpdates') }}
                </h2>
                <p>
                    {{ __('messages.News & Updates') }}
                </p>
            </div>
        @endif
    </div>
@endif
