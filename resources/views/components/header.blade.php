<nav
    class="w-full py-2 px-12 flex justify-between items-center sticky top-0 z-50
     general-header">
    <div class="min-w-max">
        <a href="{{route('index')}}"><img width="100" src="{{url(config('setting.im_log'))}}" alt="{{config('app.name')}}"></a>
    </div>
    <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
        <ul
            class="flex flex-col font-medium p-4 md:p-0 mt-4 rounded-lg md:space-x-8 rtl:space-x-reverse
                        md:flex-row md:mt-0 md:border-0">
            <li><a class="inline-block p-4 text-white {{ request('type') == '3' ? 'bg-gray-50' : '' }}"
                    href="{{route('index')}}">{{ __('Home') }}</a></li>
            <li><a class="inline-block p-4 text-white {{ request('type') == '3' ? 'bg-gray-50' : '' }}"
                    href="">{{ __('Land') }}</a>
            </li>
            @if(route("land_create"))
            <li><a class="inline-block p-4 text-white {{ request('type') == '3' ? 'bg-gray-50' : '' }}"
                href='{{route("land_create")}}'>{{__("messages.reg_land") }}</a>
            </li>
            @endif
            <li><a class="inline-block p-4 text-white {{ request('type') == '1' ? 'bg-gray-50' : '' }}"
                    href="">{{ __('messages.Residential') }}</a></li>
            <li><a class="inline-block p-4 text-white {{ request()->is('*page/about-us*') ? 'bg-gray-50' : '' }}"
                    href="#footer">
                    {{ __('messages.contact') }}</a></li>
            <li><a class="inline-block p-4 text-white  {{ request()->is('page/contact-us') ? 'bg-gray-50' : '' }}"
                    href="#footer">
                    {{ __('messages.about_u') }}</a></li>
        </ul>
    </div>


    <div class="min-w-max text-3xl flex justify-end">
        @include(config("files.components").'.user_profile',["prop" => [ "logout_url" => route('logout')]])
    </div>
    @if(!auth()->user())
        <div class="hidden w-full md:block md:w-auto">
            <a href="{{route('login')}}">{{__("messages.login")}}</a>
        </div>
    @endif

    @include("svg.toggle")
</nav>
