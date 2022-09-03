<x-guest-layout>
    @section('page-css')
     {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}">         --}}
@endsection
    @section('content')
    <x-jet-authentication-card>
        <x-slot name="logo">          
            <img src="{{asset('img/logo.jpg')}}" alt="lyskills" class="img-fluid" width="150"/>
        </x-slot>

        <a href="{{ route('google-login') }}" style="width: 25rem" class="btn btn-info btn-lg d-block my-1"> <i class="fa fa-google" aria-hidden="true"></i>
            Sign In With Google 
        </a>
        <a href="{{ route('fb-login') }}" style="width: 25rem" class="btn btn-info btn-lg  my-1 d-block"> <i class="fa fa-facebook" aria-hidden="true"></i>

            Sign In With Facebook 
        </a>
        <a href="{{ route('li-login') }}" style="width: 25rem" class="btn btn-info btn-lg  my-1 d-block"> <i class="fa fa-linkedin" aria-hidden="true"></i>            
            Sign In With LinkedIn 
        </a>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 text-sm text-blue-700 text-primary bg-blue-100 text-center font-bold">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                {{-- <x-jet-input id="email" class="block mt-1 w-full" --}}
                <x-jet-input id="email" class=""
                placeholder="Email address"
                 type="email" name="email" value="{{old('email')}}" required autofocus />
            </div>

            <div class="form-group">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <div class="flex input-group">
                    <x-jet-input id="password" class="block mt-1 w-full"
                    placeholder="password min 8 digits"
                    type="password" name="password" required autocomplete="new-password" />
                    <div class="input-group-append rounded-2xl">
                        <span class="input-group-text bg-info cursor-pointer cursor_pointer text-white" id="show_pass"><i class="fa fa-eye" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="remember_me" class="flex items-center">
                    <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>
            {{-- <div class="form-group mt-3">                
                {!! NoCaptcha::renderJs() !!}
                {!! NoCaptcha::display() !!}
                @error('g-recaptcha-response')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div> --}}

           <div class="float-right">
            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-jet-button class="ml-4 bg-website">
                    {{ __('Login') }}
                </x-jet-button>
            </div>
           </div>
        </form>
    </x-jet-authentication-card>
    @endsection
    @section('script')
        <script>
            $(function(){

                var showPassword = (pass) => {
                    if(pass.attr('type') === "password"){
                        pass.attr('type','text');
                    }else{
                        pass.attr('type','password');
                    }
                }

                var pass = $('#show_pass');
                pass.click(function(){
                    var other_el = $('#password');
                    showPassword(other_el);
                });

                
            });
         </script>
         <script>
            var seo = "Login to Lyskills an E learning platform to shape the future of your students by giving the online training of their desire course.";
            $("#seo_desc").attr('content',
            seo);
            $("#seo_fb").attr('content',seo
            );
            $('#seo_title').text('Login | Lyskills');
        </script>
    @endsection
</x-guest-layout>
