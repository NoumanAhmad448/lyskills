<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('index') }}">                        
                        <img src="{{asset('img/logo.jpg')}}" alt="lyskills" class="img-fluid" width="80"/>
                    </a>
                </div>
                {{-- <div class="pt-2 pb-3 space-y-1">
                    <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-jet-responsive-nav-link>
                </div>                 --}}
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">

                <a href="{{ route('index') }}" class="mr-3" > {{__('Student')}}  </a>
                <a href="{{ route('dashboard') }}" class="mr-3">
                    Your Dashboard
                </a>

                <x-jet-dropdown align="right" width="48">
                    <x-slot name="trigger" >
                        <div class="d-flex">
                            {{-- @if (Laravel\Jetstream\Jetstream::managesProfilePhotos()) --}}
                                
                            {{-- @else --}}
                                
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none
                                     focus:border-gray-300 transition duration-150 ease-in-out">
                                    <img class="h-12 w-12 rounded-full object-cover" src="@if(Auth::user()->profile_photo_path) {{ asset(Auth::user()->profile_photo_path) }} @else
                                    {{ Auth::user()->profile_photo_url }} @endif" alt="{{ Auth::user()->name }}" />
                                </button>

                                {{-- <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700
                                 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300
                                  transition duration-150 ease-in-out">
                                    <div>{{ Auth::user()->name }}</div> --}}

                                    {{-- <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div> --}}
                                {{-- </button> --}}
                            {{-- @endif --}}
                        </div>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Account Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Account') }}
                        </div>

                        
                        <x-jet-dropdown-link href="{{ route('dashboard') }}">
                            {{ __('Dashboard') }}
                        </x-jet-dropdown-link>
                        
                        
                        <x-jet-dropdown-link href="{{ route('i-profile') }}">
                            {{ __('Instructor Profile') }}
                        </x-jet-dropdown-link>
                        
                        <x-jet-dropdown-link href="{{ route('i-payment-setting') }}">
                            {{ __('Withdraw Payment') }}
                        </x-jet-dropdown-link>
                        <div class="border-t border-gray-100"></div>

                        <x-jet-dropdown-link href="{{ route('profile.show') }}">
                            {{ __('Setting') }}
                        </x-jet-dropdown-link>
                        <x-jet-dropdown-link href="{{ route('public-ann') }}">
                            {{ __('Public Announcement') }}
                        </x-jet-dropdown-link>
                        <x-jet-dropdown-link href="{{ route('purHis') }}">
                            {{ __('Earning History') }}
                        </x-jet-dropdown-link>
                        
                         {{-- @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                {{ __('API Tokens') }}
                            </x-jet-dropdown-link>
                        @endif  --}}

                        <div class="border-t border-gray-100"></div>

                        <!-- Team Management -->
                         {{-- @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Team') }}
                            </div>

                             Team Settings  --}}
                            {{-- <x-jet-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                {{ __('Team Settings') }}
                            </x-jet-dropdown-link> --}}

                            {{-- @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                    {{ __('Create New Team') }}
                                </x-jet-dropdown-link>
                            @endcan --}}

                            {{-- <div class="border-t border-gray-100"></div>

                            Team Switcher -->
                            <!-- <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Switch Teams') }}
                            </div> --}}

                            {{-- @foreach (Auth::user()->allTeams() as $team)
                                <x-jet-switchable-team :team="$team" />
                            @endforeach

                            <div class="border-t border-gray-100"></div>
                        @endif  --}}

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-jet-dropdown-link href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                {{ __('Logout') }}
                            </x-jet-dropdown-link>
                        </form>
                    </x-slot>
                </x-jet-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        {{-- <div class="pt-2 pb-3 space-y-1">
            <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-jet-responsive-nav-link>
        </div> --}}

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                </div>

                <div class="ml-3">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    {{-- <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div> --}}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-jet-dropdown-link href="{{ route('dashboard') }}">
                    {{ __('Dashboard') }}
                </x-jet-dropdown-link>
                
                
                <x-jet-dropdown-link href="{{ route('i-profile') }}">
                    {{ __('Instructor Profile') }}
                </x-jet-dropdown-link>
                
                <x-jet-dropdown-link href="{{ route('i-payment-setting') }}">
                    {{ __('Withdraw Payment') }}
                </x-jet-dropdown-link>
                <div class="border-t border-gray-100"></div>

                <x-jet-dropdown-link href="{{ route('profile.show') }}">
                    {{ __('Setting') }}
                </x-jet-dropdown-link>
                <x-jet-dropdown-link href="{{ route('public-ann') }}">
                    {{ __('Public Announcement') }}
                </x-jet-dropdown-link>
                <x-jet-dropdown-link href="{{ route('purHis') }}">
                    {{ __('Earning History') }}
                </x-jet-dropdown-link>
                
                {{-- @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
                @endif --}}

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                        {{ __('Logout') }}
                    </x-jet-responsive-nav-link>
                </form>

                <!-- Team Management -->
                {{-- @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-jet-responsive-nav-link>

                    <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                        {{ __('Create New Team') }}
                    </x-jet-responsive-nav-link>

                    <div class="border-t border-gray-200"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                    @endforeach
                @endif --}}
            </div>
        </div>
    </div>
</nav>