<x-guest-layout>
    
    @section('content')
    <div class="container my-5">
        <!--<x-jet-authentication-card>-->
        <div class="row"> 
            <div class="col-md-5 offset-md-4">
                
            
        <!--<x-slot name="logo" >-->
        <div class="d-flex justify-content-center">
            <img src="{{asset('img/logo.jpg')}}" alt="lyskills" class="img-fluid" width="150"/>
        </div>
        <!--</x-slot>-->


        <a href="{{ route('google-login') }}" class="btn btn-info btn-lg  my-1 d-block" style=""> <i class="fa fa-google" aria-hidden="true"></i>
            Sign Up With Google 
        </a>
        <a href="{{ route('fb-login') }}" class="btn btn-info btn-lg  my-1 d-block" style=""> <i class="fa fa-facebook" aria-hidden="true"></i>

            Sign Up With Facebook 
        </a>
        <a href="{{ route('li-login') }}" class="btn btn-info btn-lg  my-1 d-block" style=""> <i class="fa fa-linkedin" aria-hidden="true"></i>            
            Sign Up With LinkedIn 
        </a>
        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div style="">
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text"
                    placeholder="Name"
                 name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full"
                placeholder="email address"
                 type="email" name="email" :value="old('email')" required />
            </div>

            <div class="form-group mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <div class="input-group mb-3">
                  
                  <input id="password" class="form-control"
                                    placeholder="password min 8 digits"
                    type="password" name="password" required autocomplete="new-password">
                    <div class="input-group-append">
                        <span class="input-group-text bg-info cursor-pointer cursor_pointer text-white" id="show_pass"><i class="fa fa-eye" aria-hidden="true"></i>
                  </div>
            </div>

                <!--<div class="flex">-->
                <!--    <x-jet-input id="password" class="block mt-1 w-full"-->
                <!--    placeholder="password min 8 digits"-->
                <!--    type="password" name="password" required autocomplete="new-password" />-->
                <!--    <div class="input-group-append rounded-2xl">-->
                <!--        <span class="input-group-text bg-info cursor-pointer cursor_pointer text-white" id="show_pass"><i class="fa fa-eye" aria-hidden="true"></i>-->
                <!--        </span>-->
                <!--    </div>-->
                <!--</div>-->
            </div>

            <div class="form-group mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                 <div class="input-group mb-3">
                  
                  <input id="password_confirmation"
                    placeholder="confirm password"
                 class="form-control" type="password" name="password_confirmation" required autocomplete="new-password">
                    <div class="input-group-append">
                    <span class="input-group-text bg-info cursor-pointer cursor_pointer text-white" id="c_pass"><i class="fa fa-eye" aria-hidden="true"></i>
                  </div>
                <!--<div class="flex">-->
                <!--<x-jet-input id="password_confirmation"-->
                <!--    placeholder="confirm password"-->
                <!-- class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />-->
                <!-- <div class="input-group-append rounded-2xl">-->
                <!--    <span class="input-group-text bg-info cursor-pointer cursor_pointer text-white" id="c_pass"><i class="fa fa-eye" aria-hidden="true"></i>-->
                <!--    </span>-->
                <!--</div>-->
                <!-- </div>-->
            </div>
            
            <div class="form-check mt-3">
                <input class="form-check-input" type="checkbox"  id="terms" name="terms">
                <label class="form-check-label" for="terms">
                  I accept these <a href="https://lyskills.com/page/terms-and-conditions" class="text-primary">terms</a> and <a class="text-primary" href="https://lyskills.com/page/privacy-policy">conditions</a>
                </label>
              </div>

            <div class="form-group mt-3">                
                  {!! NoCaptcha::renderJs() !!}
                  {!! NoCaptcha::display() !!}
                  @error('g-recaptcha-response')
                      <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                  @enderror
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-jet-button class="ml-4 bg-website">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
        </div>
    </div>
    <!--</x-jet-authentication-card>    -->
    </div>
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

                var pass = $('#c_pass');
                pass.click(function(){
                    var other_el = $('#password_confirmation');
                    showPassword(other_el);
                });        
                
            });
         </script>
         <script>
            var seo = "Sign up as an instructor and start training of your students for changing their future by remoted way.";
            $("#seo_desc").attr('content'       ,
            seo);
            $("#seo_fb").attr('content',seo
            );
            $('#seo_title').text('Register | Lyskills');
        </script>
    @endsection
    @section('page-css')
            <!--<link rel="stylesheet" href="{{ asset('css/app.css') }}">        -->
    @endsection
</x-guest-layout>
