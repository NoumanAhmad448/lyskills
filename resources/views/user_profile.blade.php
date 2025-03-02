@php
    $user = auth()->user();
    $admin_logout = route('admin_logout');
    $user_logout = route('logout');
@endphp
@if ($user)
    <!-- User Area -->
    <div class="relative" x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false">
        <a class="flex items-center gap-4" href="#" @click.prevent="dropdownOpen = ! dropdownOpen">
            <span class="hidden text-right lg:block">
                <span class="block text-sm font-medium text-black dark:text-white">{{ $user->name }}</span>
                <span class="block text-xs font-medium">
                    {{ isAdmin(false) ? (isSuperAdmin(false) ? __('messages.spr')  : "") . __('messages.admin') : '' }}</span>
            </span>

            <span class="h-12 w-12 rounded-full">
                <img class="rounded-full object-contain hover:object-scale-down w-96"
                    src="@include('modals.profile_logo')"
                    alt="{{ $user->name }}" />
            </span>
            @include(config('files.components') . '.angle_svg')
        </a>

        <!-- Dropdown Start -->
        <div x-show="dropdownOpen"
            class="absolute right-0 bg-gray-50 z-index-40 z-50 mt-2 pt-4 flex w-62.5 flex-col rounded-sm border shadow-default
             dark:border-strokedark dark:bg-boxdark bg-white
             ">
            <ul class="relative right-0 z-index-40 flex flex-col gap-5 border-b px-6 py-7.5
                 dark:border-strokedark">

                @can(config("policy.update_profile"))
                    @include(config('files.components_') . 'profile_list', [
                        'prop' => [
                            'link' => route("my_profile"),
                            'svg' => config('files.svg') . 'profile',
                            'text' => __('messages.mprofile'),
                        ],
                    ])
                @endcan
                @can(config("policy.view_admin_dashboard"))
                    @include(config('files.components_') . 'profile_list', [
                        'prop' => [
                            'link' => route("admin_chart"),
                            'svg' => config('files.svg') . 'dashboard',
                            'text' => __('messages.dashboard'),
                        ],
                    ])
                @endcan
                @can(config("policy.view_dashboard"))
                    @include(config('files.components_') . 'profile_list', [
                        'prop' => [
                            'link' => route("land_index"),
                            'svg' => config('files.svg') . 'dashboard',
                            'text' => __('messages.usr_dshbrd'),
                        ],
                    ])
                @endcan

                @can(config("policy.view_setting"))
                    @include(config('files.components_') . 'profile_list', [
                        'prop' => [
                            'link' => route("setting"),
                            'svg' => config('files.svg') . 'setting',
                            'text' => __('messages.settings'),
                        ],
                    ])
                @endcan

            </ul>
            <form method="POST" action="@if(isAdmin(false)){{ $admin_logout }} @else {{ $user_logout }} @endif">
                @include(config("files.components_").'csrf')
            <button type="submit"
                class="flex items-center gap-3.5 px-6 py-4 text-sm font-medium duration-300 ease-in-out
                 hover:text-primary lg:text-base">
                @include(config('files.svg') . 'logout')
                {{__("messages.logout")}}
            </button>
            </form>
        </div>
        <!-- Dropdown End -->
    </div>
    <!-- User Area -->
@endif
