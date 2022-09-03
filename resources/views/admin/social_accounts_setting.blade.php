@extends('admin.admin_main')


@section('page-css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
  <h1> Social Settings </h1>
  <hr/>
  <ul class="nav nav-pills mb-3" id="social-option" role="tablist">
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="facebook" data-toggle="pill" href="#facebook-form" role="tab" 
      aria-selected="true"> <i class="fa fa-facebook-official" aria-hidden="true"></i>
      facebook</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="google" data-toggle="pill" href="#google-form" role="tab" 
      aria-selected="false"> <i class="fa fa-google" aria-hidden="true"></i>
            Google </a>
    </li>   
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="linkedin" data-toggle="pill" href="#linkedin_form" role="tab" 
      aria-selected="false"> <i class="fa fa-linkedin" aria-hidden="true"></i>
          Linkedin </a>
    </li>      
  </ul>

<div class="tab-content" >

    <div class="tab-pane fade show " id="facebook-form" role="tabpanel" aria-labelledby="facebook">
        <section>
            <h2> Facebook </h2>
            <hr/>
            @include('session_msg')
            <form action="{{route('social_networks_fb')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6 offset-md-4 d-flex justify-content-end">
                  <div class="form-label my-3 icon-sm cursor_pointer ">
                    <i class="fa fa-eye-slash hide_fields" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="enable"> Enable/Disable  </label>
                </div>
                <div class="col-md-6">      
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="enable" name="enable" 
                        @if(isset($social) && $social->f_enable) {{ __('checked')}} @endif>
                    <label class="custom-control-label" for="enable">Enable/Disable</label>
                </div>                           
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-4">
                    <label for="fb_app_key"> App Key  </label>
                </div>
                <div class="col-md-6">                
                    <input type="text" class="form-control hide @error('fb_app_key') is-invalid @enderror" id="fb_app_key" name="fb_app_key"                   
                    placeholder="App key" value="@if(isset($social)){{$social->f_app_id ?? '' }}@endif" />                                  
                    @error('fb_app_key')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror 
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-4">
                    <label for="fb_secret_key"> Secret Key  </label>
                </div>
                <div class="col-md-6">                
                    <input type="text" class="form-control hide @error('fb_secret_key') is-invalid @enderror" id="fb_secret_key" name="fb_secret_key"                   
                    
                    placeholder="Secret key" value="@if(isset($social)){{$social->f_security_key ?? '' }}@endif" />                                  
                    @error('fb_secret_key')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror 
                </div>
            </div>
            <div class="row mt-4">             
                <div class="col-md-6 offset-md-4">                
                    <input type="submit" value="Save" class="btn btn-primary" />                                  
                </div>
            </div>
            </form>
        </section>
    </div>
    
    <div class="tab-pane fade show" id="google-form" role="tabpanel"  aria-labelledby="google" >
      <section>
        <h2> Google </h2>
        <hr/>
        @include('session_msg')
        <form action="{{route('social_networks_g')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6 offset-md-4 d-flex justify-content-end">
                  <div class="form-label my-3 icon-sm cursor_pointer ">
                    <i class="fa fa-eye-slash hide_fields" aria-hidden="true"></i>
                  </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-4">
                <label for="enable_g"> Enable/Disable  </label>
            </div>
            <div class="col-md-6">      
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="enable_g" name="enable_g"
                    @if(isset($social) && $social->g_enable) {{ __('checked')}} @endif
                    >
                    <label class="custom-control-label" for="enable_g">Enable/Disable</label>
                </div>                           
            </div>
            </div>
            <div class="row mt-4">
            <div class="col-md-4">
                <label for="g_app_key"> App Key  </label>
            </div>
            <div class="col-md-6">                
                <input type="text" class="form-control hide @error('g_app_key') is-invalid @enderror" id="g_app_key" name="g_app_key"                   
                    placeholder="App Key" value="@if(isset($social)){{$social->g_app_id ?? '' }}@endif" />                                  
                @error('g_app_key')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror 
            </div>
            </div>
            <div class="row mt-4">
            <div class="col-md-4">
                <label for="g_secret_key"> Secret Key  </label>
            </div>
            <div class="col-md-6">                
                <input type="text" class="form-control hide @error('g_secret_key') is-invalid @enderror" id="g_secret_key" name="g_secret_key"                   
                
                placeholder="Secret key" value="@if(isset($social)){{$social->g_security_key ?? '' }}@endif" />                                  
                @error('g_secret_key')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror 
            </div>
            </div>
            <div class="row mt-4">             
            <div class="col-md-6 offset-md-4">                
                <input type="submit" value="Save" class="btn btn-primary" />                                  
            </div>
            </div>
        </form>
        </section>
        
    </div>
    
    <div class="tab-pane fade show" id="linkedin_form" role="tabpanel"  aria-labelledby="linkedin">
    <section>
        <h2> Linkedin </h2>
        <hr/>
        @include('session_msg')
        <form action="{{route('social_networks_li')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6 offset-md-4 d-flex justify-content-end">
                  <div class="form-label my-3 icon-sm cursor_pointer ">
                    <i class="fa fa-eye-slash hide_fields" aria-hidden="true"></i>
                  </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-4">
                <label for="enable_l"> Enable/Disable  </label>
            </div>
            <div class="col-md-6">      
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="enable_l" name="enable_l"
                    @if(isset($social) && $social->l_enable) {{ __('checked')}} @endif
                    />
                    <label class="custom-control-label" for="enable_l">Enable/Disable</label>
                </div>                           
            </div>
            </div>
            <div class="row mt-4">
            <div class="col-md-4">
                <label for="l_app_key"> App Key  </label>
            </div>
            <div class="col-md-6">                
                <input type="text" class="form-control hide @error('l_app_key') is-invalid @enderror" id="l_app_key" name="l_app_key"                   
                placeholder="App key" value="@if(isset($social)){{$social->l_app_id ?? '' }}@endif" />                                  
                @error('l_app_key')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror 
            </div>
            </div>
            <div class="row mt-4">
            <div class="col-md-4">
                <label for="l_secret_key"> Secret Key  </label>
            </div>
            <div class="col-md-6">                
                <input type="text" class="form-control hide @error('l_secret_key') is-invalid @enderror" id="l_secret_key" name="l_secret_key"                   
                
                placeholder="Secret key" value="@if(isset($social)){{$social->l_security_key ?? '' }}@endif" />                                  
                @error('l_secret_key')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror 
            </div>
            </div>
            <div class="row mt-4">             
            <div class="col-md-6 offset-md-4">                
                <input type="submit" value="Save" class="btn btn-primary" />                                  
            </div>
            </div>
        </form>
        </section>
        
    </div>
    
</div>


@endsection




@section('page-js')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" 
      integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous">
    </script>

    <script>
      $(function(){
          $('.s_sub_menu').removeClass('d-none');
          $('#social_networks').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');  
          
          var resetValues = (current_obj) =>{
                $('.alert').fadeOut();
                current_obj.removeClass('is-invalid');
            }

            let values = $('input');
            setTimeout(() => {
                
                resetValues(values);
            }, 5000);

            values.click(()=>{
                resetValues(values);
            });

            var hash = location.hash;    
            switch (hash) {
              case '#google-form':                
                  $('#google').addClass('active');
                  $(hash).addClass('active');
                break;
              case '#linkedin_form':                
                  $('#linkedin').addClass('active');
                  $(hash).addClass('active');
                break;             
            
              default:
                  $('#facebook , #facebook-form').addClass('active');                  
                break;
            }

            $('.hide_fields').click(() => {
              const el = $('.hide');  
              if(el.attr('type') === "text"){
                el.attr('type','password');            
                $('.hide_fields').removeClass('fa-eye-slash').addClass('fa-eye');            
              }else{
                el.attr('type','text');
                $('.hide_fields').addClass('fa-eye-slash').removeClass('fa-eye');
              }
            });
      });


    </script>
@endsection