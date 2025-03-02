@if(config("setting.en_articleadvices_con"))

<div class="container">
    @if(config("setting.en_articleadvices"))

    <div class="pt-20">
        <h2 class="section-title text-4xl text-center pb-8 langBN">{{ __('Article & Advices') }}</h2>
        <div class="md:flex -mx-4">
            @foreach([1,2,3] as $_)
                <div class="md:flex-1 px-4 mt-7 md:mt-3">
                    <div class="bg-white rounded-xl flex">
                        <div style="min-width:130px; background-image: url(https://picsum.photos/1200/800)" class="bg-cover bg-center"></div>
                        <div class="p-4">
                            <h3 class="mb-4 text-xl">Lorem ipsum dolor sit amet, consectetur</h3>
                            <a href="" class="fullwidth-btn">Read More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    @if(config("setting.en_contact"))
    <div class="py-20 text-lg border-b-2 border-gray-300 pb-16 mb-20 flex flex-col justify-center items-center
                text-center">
        <h2 class="mb-4 text-4xl font-extrabold leading-none
                     tracking-tight md:text-5xl lg:text-6xl dark:text-white">
            {{ __("messages.contact") }}
       </h2>
        <p>
            {{ __("messages.getting_invol") }}
        </p>
    </div>
    @endif

    @if(config("setting.en_footer"))
    <div class="md:flex pb-12 text-center md:text-left" id="footer">
        <div class="lg:w-1/4 pr-6 flex justify-center items-center
                md:block grid place-items-center">
            <img class="rounded" width="100" src="{{url(config('setting.im_welcome'))}}" alt="{{ __("messages.welcome") }}">
            <p class="text-sm mt-7">{{ __("messages.wel_title") }}</p>
        </div>

        <div class="md:w-2/4 font-bold leading-8 mt-4 md:mt-0">
        </div>
        <div class="md:w-1/4 pr-6 mt-4 md:mt-0">
            <div class="text-sm font-bold">{{ __("messages.address")}}</div>
            <div class="text-sm mt-2">{{ config("setting.address")}}</div>
            <div class="text-sm mt-2 font-bold">{{ __("messages.phone_no")}}</div>
            <div class="text-sm mt-2">{{ config("setting.phone_num")}}</div>
            <div class="text-sm mt-2 font-bold">{{ __("messages.email")}}</div>
            <div class="text-sm mt-2 {{config("setting.link")}}"><a href='mailto:{{ config("setting.email")}}'>{{ config("setting.email")}}</a></div>
        </div>
    </div>
    @endif

</div>
@endif
