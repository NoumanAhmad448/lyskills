<x-guest-layout>
    @section('page-css')
            {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}">         --}}
    @endsection
    @section('content')
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img src="{{asset('img/logo.jpg')}}" alt="lyskills" class="img-fluid" width="150"/>
        </x-slot>
        <!-- <hr class="mb-4"/> -->

        <div class="mb-4 text-sm" style="width: 25rem"> 
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 text-sm text-blue-700 bg-blue-100 text-center font-bold">
                {{ session('status') }}
            </div>
        @endif

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" 
                placeholder="Email" type="email" name="email" :value="old('email')" required autofocus />
            </div>
            <div class="form-group mt-3">                
                {!! NoCaptcha::renderJs() !!}
                {!! NoCaptcha::display() !!}
                @error('g-recaptcha-response')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-4 float-right">
                <x-jet-button class="bg-website">
                    {{ __('Email Password Reset Link') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>

    @endsection
    @section('script')
    <script>
        var seo = "If you forget your password then reset your password to login again on lyskills, an online educational platform.";
        $("#seo_desc").attr('content',
        seo);
        $("#seo_fb").attr('content',seo
        );
        $('#seo_title').text('Forgot Password | Lyskills');
    </script>
    @endsection
</x-guest-layout>
