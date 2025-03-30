<x-guest-layout>
    @section('content')
        <x-jet-authentication-card>
            <x-slot name="logo">
                <img src="{{ asset(config('setting.img_logo_path')) }}" alt="lyskills" class="img-fluid" width="150" />
            </x-slot>
            <div>
                <div class="mb-4 text-sm text-gray-600 text-center">
                    {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
                </div>

                <div class="mb-4 text-sm text-gray-600 text-center" x-show="recovery">
                    {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
                </div>

                <x-jet-validation-errors class="mb-4" />

                <form method="POST" action="/two-factor-challenge">
                    @csrf

                    <div class="mt-4">
                        <x-jet-label for="code" value="{{ __('Code') }}" />
                        <x-jet-input id="code" class="block mt-1 w-full" type="text" inputmode="numeric"
                            name="code" autofocus x-ref="code" autocomplete="one-time-code" />
                    </div>

                    <div class="mt-4" x-show="recovery">
                        <x-jet-label for="recovery_code" value="{{ __('Recovery Code') }}" />
                        <x-jet-input id="recovery_code" class="block mt-1 w-full" type="text" name="recovery_code"
                            x-ref="recovery_code" autocomplete="one-time-code" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-jet-button class="ml-4 btn btn-website float-right">
                            {{ __('Login') }}
                        </x-jet-button>

                    </div>
                </form>
            </div>
        </x-jet-authentication-card>
    @endsection
</x-guest-layout>
