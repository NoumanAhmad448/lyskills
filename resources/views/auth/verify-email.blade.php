<x-guest-layout>
    @section('content')
    <x-jet-authentication-card>
        <x-slot name="logo">
            {{-- <x-jet-authentication-card-logo /> --}}
            <img src="{{asset('img/logo.jpg')}}" alt="lyskills" class="img-fluid" width="150"/>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600 text-center">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600 text-center">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif
        <div class="mt-4 flex items-center justify-between">
            <!-- <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-jet-button type="submit">
                        {{ __('Resend Verification Email') }}
                    </x-jet-button>
                </div>
            </form> -->

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <div class="d-flex justify-content-center">
                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 btn btn-outline-website">
                        {{ __('Logout') }}
                    </button>
                </div>
            </form>
        </div>
    </x-jet-authentication-card>
    @endsection
</x-guest-layout>
