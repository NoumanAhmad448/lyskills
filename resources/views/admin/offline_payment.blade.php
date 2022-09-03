@extends('admin.admin_main')

@section('page-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<h1> Offline Payment  </h1>
<hr/>
<ul class="nav nav-pills mb-3" id="payment-options" role="tablist">
  
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="Jazzcash" data-toggle="pill" href="#jazzcash_form" role="tab" 
    aria-selected="false"> <i class="fa fa-fighter-jet" aria-hidden="true"></i> JazzCash </a>
  </li>   
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="easypaisa" data-toggle="pill" href="#easypaisa_form" role="tab" 
    aria-selected="false"> <i class="fa fa-etsy" aria-hidden="true"></i> EasyPaisa </a>
  </li>   
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="bank" data-toggle="pill" href="#bank-form" role="tab" 
    aria-selected="false"> <i class="fa fa-etsy" aria-hidden="true"></i> Bank </a>
  </li>   
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="other" data-toggle="pill" href="#other-form" role="tab" 
    aria-selected="false"> <i class="fa fa-money" aria-hidden="true"></i>   Other </a>
  </li>   
  
</ul>

  <div class="tab-content" id="payment-optionsContent">   
    
 
    <div class="tab-pane fade show" id="jazzcash_form" role="tabpanel"  aria-labelledby="Jazzcash">
      <section>
        <h2> Jazzcash </h2>
        <hr/>
        @include('session_msg')
        <form action="{{route('a_jazzcash_offline_payment')}}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-4">
                <div> Enable/Disable </div>
            </div>
            <div class="col-md-6">
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="j_form" name="j_form" 
                        @if(isset($offline) && $offline->j_is_enable) {{ __('checked') }} @endif/>
                <label class="custom-control-label" for="j_form"> Enable/Disable </label>
              </div>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-md-4">
                <label for="j_mobile_no"> JazzCash Mobile Number  </label>
            </div>
            <div class="col-md-6">                
                <input type="text" class="form-control @error('j_mobile_no') is-invalid @enderror" id="j_mobile_no"
                  value="@if(isset($offline)){{ $offline->j_mobile_number ?? '' }} @endif"
                   name="j_mobile_no" placeholder="Jazzcash mobile number"> 
                @error('j_mobile_no')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror                                 
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-md-4">
                <label for="j_account_name"> Account Name  </label>
            </div>
            <div class="col-md-6">                
                <input type="text" class="form-control @error('j_account_name') is-invalid @enderror" id="j_account_name" name="j_account_name" 
                value="@if(isset($offline)){{ $offline->j_account_name ?? '' }} @endif"
                placeholder="Jazzcash Account Name" />                                  
                @error('j_account_name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror 
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-md-4">
                <label for="j_note"> Note  </label>
            </div>
            <div class="col-md-6">                
                <textarea  class="form-control @error('j_note') is-invalid @enderror" id="j_note" name="j_note" 
                
                placeholder="Jazzcash Note" 
                rows="10"
                >@if(isset($offline)) {{ $offline->j_note ?? '' }}@endif</textarea>                                  
                @error('j_note')
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
        <form action="{{route('a_easypaisa_offline_payment')}}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-4">
                <div> Enable/Disable </div>
            </div>
            <div class="col-md-6">
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="easypaisa___form" name="easypaisa___form" 
                        @if(isset($offline) && $offline->e_is_enable) {{ __('checked') }} @endif/>
                <label class="custom-control-label" for="easypaisa___form"> Enable/Disable </label>
              </div>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-md-4">
                <label for="e_mobile_number"> Easypaisa Mobile Number  </label>
            </div>
            <div class="col-md-6">                
                <input type="text" class="form-control @error('e_mobile_number') is-invalid @enderror" id="e_mobile_number"
                  value="@if(isset($offline)){{ $offline->e_mobile_number ?? ''}}@endif"
                name="e_mobile_number"  placeholder="Easypaisa Mobile Number"> 
                @error('e_mobile_number')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror                                 
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-md-4">
                <label for="e_account_name"> Account Name  </label>
            </div>
            <div class="col-md-6">                
                <input type="text" class="form-control @error('e_account_name') is-invalid @enderror" id="e_account_name" name="e_account_name" 
                value="@if(isset($offline)){{ $offline->e_account_name ?? '' }}@endif"
                placeholder="Easypaisa Account Name" />                                  
                @error('e_account_name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror 
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-md-4">
                <label for="e_note"> Live Publishable Key  </label>
            </div>
            <div class="col-md-6">                
                <textarea class="form-control @error('e_note') is-invalid @enderror" id="e_note" name="e_note" 
                placeholder="Easypaisa note" 
                rows="10"
                >@if(isset($offline)){{ $offline->e_note ?? '' }}@endif</textarea>                                  
                @error('e_note')
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
    <div class="tab-pane fade show" id="bank-form" role="tabpanel"  aria-labelledby="easypaisa">
      <section>
        <h2> Bank </h2>
        <hr/>
        @include('session_msg')
        <form action="{{route('a_bank_offline_payment')}}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-4">
                <div> Enable/Disable </div>
            </div>
            <div class="col-md-6">
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="b_is_enable" name="b_is_enable" 
                        @if(isset($offline) && $offline->b_is_enable) {{ __('checked') }} @endif/>
                <label class="custom-control-label" for="b_is_enable"> Enable/Disable </label>
              </div>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-md-4">
                <label for="b_bank_name"> Bank Name  </label>
            </div>
            <div class="col-md-6">                
                <input type="text" class="form-control @error('b_bank_name') is-invalid @enderror" id="b_bank_name"
                  value="@if(isset($offline)){{ $offline->b_bank_name ?? ''}}@endif"
                name="b_bank_name"  placeholder="Bank Name"> 
                @error('b_bank_name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror                                 
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-md-4">
                <label for="b_swift_code"> Swift Code  </label>
            </div>
            <div class="col-md-6">                
                <input type="text" class="form-control @error('b_swift_code') is-invalid @enderror" id="b_swift_code"
                  value="@if(isset($offline)){{ $offline->b_swift_code ?? ''}}@endif"
                name="b_swift_code"  placeholder="swift code"> 
                @error('b_swift_code')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror                                 
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-md-4">
                <label for="b_account_name"> Account Name  </label>
            </div>
            <div class="col-md-6">                
                <input type="text" class="form-control @error('b_account_name') is-invalid @enderror" id="b_account_name" name="b_account_name" 
                value="@if(isset($offline)){{ $offline->b_account_name ?? '' }}@endif"
                placeholder="Account Name" />                                  
                @error('b_account_name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror 
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-md-4">
                <label for="b_account_number"> Account Number  </label>
            </div>
            <div class="col-md-6">                
                <input type="text" class="form-control @error('b_account_number') is-invalid @enderror" id="b_account_number" name="b_account_number" 
                value="@if(isset($offline)){{ $offline->b_account_number ?? '' }}@endif"
                placeholder="Account Name" />                                  
                @error('b_account_number')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror 
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-md-4">
                <label for="b_branch_name"> Branch Name  </label>
            </div>
            <div class="col-md-6">                
                <input type="text" class="form-control @error('b_branch_name') is-invalid @enderror" id="b_branch_name" name="b_branch_name" 
                value="@if(isset($offline)){{ $offline->b_branch_name ?? '' }}@endif"
                placeholder="branch name" />                                  
                @error('b_branch_name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror 
            </div>
          </div>
          
          <div class="row mt-4">
            <div class="col-md-4">
                <label for="b_branch_address"> Branch Address  </label>
            </div>
            <div class="col-md-6">                
                <input type="text" class="form-control @error('b_branch_address') is-invalid @enderror" id="b_branch_address" name="b_branch_address" 
                value="@if(isset($offline)){{ $offline->b_branch_address ?? '' }}@endif"
                placeholder="branch Address" />                                  
                @error('b_branch_address')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror 
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-md-4">
                <label for="b_iban"> Bank IBAN  </label>
            </div>
            <div class="col-md-6">                
                <input type="text" class="form-control @error('b_iban') is-invalid @enderror" id="b_iban" name="b_iban" 
                value="@if(isset($offline)){{ $offline->b_iban ?? '' }}@endif"
                placeholder="IBAN number" />                                  
                @error('b_iban')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror 
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-md-4">
                <label for="b_note"> Note  </label>
            </div>
            <div class="col-md-6">                
                <textarea class="form-control @error('b_note') is-invalid @enderror" id="b_note" name="b_note" 
                placeholder="note" 
                rows="10"
                >@if(isset($offline)){{ $offline->b_note ?? '' }}@endif</textarea>                                  
                @error('b_note')
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

    <div class="tab-pane fade show" id="other-form" role="tabpanel"  aria-labelledby="other payment" >
        <section>
          <h2> Other </h2>
          <hr/>
          @include('session_msg')
          <form action="{{route('a_other_offline_payment')}}" method="post">
            @csrf
            <div class="row">
              <div class="col-md-4">
                  <div> Enable/Disable </div>
              </div>
              <div class="col-md-6">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="other_form" name="other_form" 
                          @if(isset($offline) && $offline->o_is_enable) {{ __('checked') }} @endif/>
                  <label class="custom-control-label" for="other_form"> Enable/Disable </label>
                </div>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-md-4">
                  <label for="o_mobile"> Mobile Number  </label>
              </div>
              <div class="col-md-6">                
                  <input type="text" class="form-control @error('o_mobile') is-invalid @enderror" id="o_mobile"
                    value="@if(isset($offline)){{$offline->o_mobile_number ?? '' }}@endif"
                  name="o_mobile" placeholder="mobile number"> 
                  @error('o_mobile')
                      <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror                                 
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-md-4">
                  <label for="o_note"> Note  </label>
              </div>
              <div class="col-md-6">                
                  <textarea class="form-control @error('o_note') is-invalid @enderror" id="o_note" name="o_note" rows="10"
                  placeholder="Note">@if(isset($offline)){{removeSpace($offline->o_note) ?? '' }}@endif</textarea>                                  
                  @error('o_note')
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
            $('#a_offline_payment_gateways').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');   
            var resetValues = (current_obj) =>{
                $('.alert').fadeOut();
                current_obj.removeClass('is-invalid');
            }

            let values = $("input , textarea");
            setTimeout(() => {
                
                resetValues(values);
            }, 15000);

            values.click(()=>{
                resetValues(values);
            });

            $('.s_sub_menu').removeClass('d-none');

            var hash = location.hash;    
            switch (hash) {
              case '#other-form':                
                  $('#other').addClass('active');
                  $(hash).addClass('active');
                break;
                case '#easypaisa_form':                
                $('#easypaisa').addClass('active');
                $(hash).addClass('active');
                break;            
                case '#bank-form':                
                $('#bank').addClass('active');
                $(hash).addClass('active');
                break;            
                default:            
                    $('#Jazzcash').addClass('active');
                    $('#jazzcash_form').addClass('active');
                break;
              }

        });
    
    </script>
@endsection