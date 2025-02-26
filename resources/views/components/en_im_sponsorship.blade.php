@if (config('setting.en_im_sponsorship'))
    <div class="container pt-14 sm:mt-10">
        <div class="md:flex md:justify-between md:items-center">
            <div class="flex-1 hover:-translate-y-1 hover:scale-110 hover:bg-indigo-500 duration-300
                transition ease-in-out delay-150 animate-pulse
                "
                data-twe-animation-start="onScroll">
                <img class="rounded" src="{{ url(config('setting.im_sponsorship')) }}"
                    alt="{{ __('messages.Sponsorship') }}">
            </div>
            <div class="flex-1 ml-10 text-lg leading-normal justify-center items-center">
                <h2
                    class="flex flex-col justify-center items-center mb-4 text-4xl font-extrabold leading-none
                            tracking-tight md:text-5xl lg:text-6xl dark:text-white">
                    {{ __('messages.Sponsorship') }}
                </h2>
                <p>{{ __('messages.Sponsorship_desc') }}</p>
            </div>
        </div>
    </div>
@endif
