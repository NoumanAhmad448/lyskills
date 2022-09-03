@extends('admin.admin_main')


@section('page-css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
  <h1> Payment Gateways </h1>
  <hr/>
  <ul class="nav nav-pills mb-3" id="payment-options" role="tablist">
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="stripe" data-toggle="pill" href="#stripe-form" role="tab" 
      aria-selected="true"> <i class="fa fa-cc-stripe" aria-hidden="true"></i>  Stripe</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="paypal" data-toggle="pill" href="#paypal-form" role="tab" 
      aria-selected="false"> <i class="fa fa-paypal" aria-hidden="true"></i> Paypal </a>
    </li>   
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="Jazzcash" data-toggle="pill" href="#jazzcash__form" role="tab" 
      aria-selected="false"> <i class="fa fa-fighter-jet" aria-hidden="true"></i> JazzCash </a>
    </li>   
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="easypaisa" data-toggle="pill" href="#easypaisa_form" role="tab" 
      aria-selected="false"> <i class="fa fa-etsy" aria-hidden="true"></i> EasyPaisa </a>
    </li>   
  </ul>

    <div class="tab-content" id="payment-optionsContent">
      <div class="tab-pane fade show " id="stripe-form" role="tabpanel" aria-labelledby="strip">
        <section>
          <h2> Stripe </h2>
          <hr/>
          @include('session_msg')
          <form action="{{route('a_strip_payment')}}" method="post">
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
                  <div> Enable/Disable </div>
              </div>
              <div class="col-md-6">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="strip_form" name="strip_form" 
                          @if(isset($setting) && $setting->s_is_enable) {{ __('checked') }} @endif/>
                  <label class="custom-control-label" for="strip_form"> Enable/Disable </label>
                </div>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-md-4">
                  <label for="s_s_key"> Stripe Secret Key  </label>
              </div>
              <div class="col-md-6">                
                  <input type="text" class="form-control hide @error('s_s_key') is-invalid @enderror" id="s_s_key"
                    value="@if(isset($setting)){{ $setting->s_live_key ?? '' }}@endif"
                  name="s_s_key"  placeholder="Stripe Secret Key"> 
                  @error('s_s_key')
                      <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror                                 
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-md-4">
                  <label for="s_p_key"> Live Publishable Key  </label>
              </div>
              <div class="col-md-6">                
                  <input type="text" class="form-control hide @error('s_p_key') is-invalid @enderror" id="s_p_key" name="s_p_key" 
                  value="@if(isset($setting)){{$setting->s_publish_key ?? '' }}@endif"
                  placeholder="Stripe Publishable Key" />                                  
                  @error('s_p_key')
                      <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror 
              </div>
            </div>
            <div class="row mt-4">             
              <div class="col-md-6 offset-md-4">                  
                  <input type="submit"  value="Save" class="btn btn-primary" />                                  
              </div>
            </div>
          </form>
        </section>

      </div>
      
      <div class="tab-pane fade show" id="paypal-form" role="tabpanel"  aria-labelledby="paypal" >
        <section>
          <h2> Paypal </h2>
          <hr/>
          @include('session_msg')
          <form action="{{route('a_paypal_payment')}}" method="post">
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
                  <div> Enable/Disable </div>
              </div>
              <div class="col-md-6">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="paypal_form" name="paypal_form" 
                          @if(isset($setting) && $setting->paypal_is_enable) {{ __('checked') }} @endif/>
                  <label class="custom-control-label" for="paypal_form"> Enable/Disable </label>
                </div>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-md-4">
                  <label for="p_s_key"> Paypal Secret Key  </label>
              </div>
              <div class="col-md-6">                
                  <input type="text" class="form-control hide @error('p_s_key') is-invalid @enderror" id="p_s_key"
                    value="@if(isset($setting)){{ $setting->p_live_key ?? '' }}@endif"
                  name="p_s_key" placeholder="Paypal Secret Key"> 
                  @error('p_s_key')
                      <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror                                 
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-md-4">
                  <label for="p_p_key"> Live Publishable Key  </label>
              </div>
              <div class="col-md-6">                
                  <input type="text" class="form-control hide @error('p_p_key') is-invalid @enderror" id="p_p_key" name="p_p_key" 
                  value="@if(isset($setting) ){{$setting->p_publish_key ?? '' }}@endif"
                  placeholder="Paypal Publishable Key" />                                  
                  @error('p_p_key')
                      <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror 
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-md-4">
                  <label for="paypal_email"> Paypal Email  </label>
              </div>
              <div class="col-md-6">                
                  <input type="text" class="form-control hide @error('paypal_email') is-invalid @enderror" id="paypal_email" name="paypal_email" 
                  value="@if(isset($setting)){{  $setting->paypal_email ?? '' }}@endif"
                      placeholder="Paypal Email" />                                  
                  @error('paypal_email')
                      <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror 
              </div>
            </div>
            <div class="row mt-4">             
              <div class="col-md-6 offset-md-4">                
                  <input type="submit"  value="Save" class="btn btn-primary" />                                  
              </div>
            </div>
          </form>
        </section>
      </div>
      
      <div class="tab-pane fade show" id="jazzcash__form" role="tabpanel"  aria-labelledby="Jazzcash">
        <section>
          <h2> Jazzcash </h2>
          <hr/>
          @include('session_msg')
          <form action="{{route('a_jazzcash_payment')}}" method="post">
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
                  <div> Enable/Disable </div>
              </div>
              <div class="col-md-6">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="jazzcash_form" name="jazzcash_form" 
                          @if(isset($setting) && $setting->j_is_enable) {{ __('checked') }} @endif/>
                  <label class="custom-control-label" for="jazzcash_form"> Enable/Disable </label>
                </div>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-md-4">
                  <label for="j_s_key"> JazzCash Secret Key  </label>
              </div>
              <div class="col-md-6">                
                  <input type="text" class="form-control hide @error('j_s_key') is-invalid @enderror" id="j_s_key"
                    value="@if(isset($setting)){{ $setting->j_live_key ?? '' }}@endif"
                  name="j_s_key" placeholder="Jazzcash Secret Key"> 
                  @error('j_s_key')
                      <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror                                 
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-md-4">
                  <label for="j_p_key"> Live Publishable Key  </label>
              </div>
              <div class="col-md-6">                
                  <input type="text" class="form-control hide @error('j_p_key') is-invalid @enderror" id="j_p_key" name="j_p_key" 
                  value="@if(isset($setting)){{$setting->j_publish_key ?? '' }}@endif"
                  placeholder="Jazzcash Publishable Key" />                                  
                  @error('j_p_key')
                      <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror 
              </div>
            </div>
            <div class="row mt-4">             
              <div class="col-md-6 offset-md-4">                
                  <input type="submit"  value="Save" class="btn btn-primary" />                                  
              </div>
            </div>
          </form>
        </section>
      </div>
      
      <div class="tab-pane fade show" id="easypaisa_form" role="tabpanel"  aria-labelledby="easypaisa">
        <section>
          <h2> Easypaisa </h2>
          <hr/>
          @include('session_msg')
          <form action="{{route('a_easypaisa_payment')}}" method="post">
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
                  <div> Enable/Disable </div>
              </div>
              <div class="col-md-6">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="easypaisa___form" name="easypaisa___form" 
                          @if(isset($setting) && $setting->e_is_enable) {{ __('checked') }} @endif/>
                  <label class="custom-control-label" for="easypaisa___form"> Enable/Disable </label>
                </div>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-md-4">
                  <label for="e_s_key"> Easypaisa Secret Key  </label>
              </div>
              <div class="col-md-6">                
                  <input type="text" class="form-control hide @error('e_s_key') is-invalid @enderror" id="e_s_key"
                    value="@if(isset($setting)){{  $setting->e_live_key ?? '' }}@endif"
                  name="e_s_key"  placeholder="Easypaisa Secret Key"> 
                  @error('e_s_key')
                      <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror                                 
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-md-4">
                  <label for="e_p_key"> Live Publishable Key  </label>
              </div>
              <div class="col-md-6">                
                  <input type="text" class="form-control hide @error('e_p_key') is-invalid @enderror" id="e_p_key" name="e_p_key" 
                  value="@if(isset($setting)){{  $setting->e_publish_key ?? '' }}@endif"
                  placeholder="Easypaisa Publishable Key" />                                  
                  @error('e_p_key')
                      <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror 
              </div>
            </div>
            <div class="row mt-4">             
              <div class="col-md-6 offset-md-4">                
                  <input type="submit"  value="Save" class="btn btn-primary" />                                  
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
          $('#a_payment_gateways').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');  
          
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
              case '#paypal-form':                
                  $('#paypal').addClass('active');
                  $(hash).addClass('active');
                break;
              case '#jazzcash__form':                
                  $('#Jazzcash').addClass('active');
                  $(hash).addClass('active');
                break;
              case '#easypaisa_form':                
                  $('#easypaisa').addClass('active');
                  $(hash).addClass('active');
                break;
            
              default:
                  $('#stripe , #stripe-form').addClass('active');                  
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