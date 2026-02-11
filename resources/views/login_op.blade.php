@if (Route::has('login'))
    @auth
        <div class="dropdown mx-3">
            @if (config('setting.login_profile'))
                <div class="cursor_pointer text-center  pt-2" id="user_menu" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <img height="50" width="50" class="rounded-circle object-cover"
                        src="@if (Auth::user()->profile_photo_path && !config('setting.store_img_s3')) {{ asset(Auth::user()->profile_photo_path) }}
                                @elseif(config('setting.store_img_s3'))
                                        {{ config('s3Url') }}{{ Auth::user()->profile_photo_url }}
                                @else
                                        {{ Auth::user()->profile_photo_url }} @endif"
                        alt="{{ Auth::user()->name }}" />
                </div>
            @endif
            <div class="dropdown-menu dropdown-menu-right  w-55 mr-4 border" aria-labelledby="user_menu">
                <a class="pt-2 dropdown-item" href="{{ route('myLearning') }}">
                    {{ __('My Learning') }}</a>
                <a class="pt-2 dropdown-item" href="{{ route('get-wishlist-course') }}">
                    {{ __('WishList') }}</a>
                <a class="pt-2 dropdown-item" href="{{ route('profile.show') }}">
                    {{ __('Setting') }}</a>
                <div class="dropdown-divider"></div>
                <a class="pt-2 dropdown-item" href="{{ route('dashboard') }}">
                    {{ __('Instructor Dashboard') }}</a>
                {{-- <a class="pt-2 dropdown-item" href="{{ route('chat_w_i') }}"> {{__('Contact With Instructor')}}</a>                               --}}
                <a class="pt-2 dropdown-item" href="{{ route('email_to_ins') }}">
                    {{ __('Contact With Instructor') }}</a>
                <div class="dropdown-divider"></div>
                <a class="pt-2 dropdown-item" href="{{ route('pay_his') }}">
                    {{ __('Purchase History') }}</a>
                <a class="pt-2 dropdown-item" href="{{ route('public_faq') }}">
                    {{ __('Help') }}</a>
                <a class="pt-1 dropdown-item" href="{{ route('logout_user') }}">
                    {{ __('Logout') }}</a>
            </div>
        </div>
    @else
        <div class="d-flex justify-content-end">
            <a href="{{ route('login') }}" class="btn btn-info mr-1 mt-3">Log in</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-outline-info mt-3">Sign Up</a>
            @endif
        </div>
    @endauth
@endif
