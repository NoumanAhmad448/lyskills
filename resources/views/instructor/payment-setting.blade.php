@extends('layouts.dashboard_header')


@section('page-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
    integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
@endsection
@section('content')
<div class="container">

    <h1> Withdraw Setting </h1>
    <hr />
    <ul class="nav nav-pills mb-3" id="payment-options" role="tablist">
        @if($offline_setting && $offline_setting->b_is_enable)
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="bank" data-toggle="pill" href="#bank-form" role="tab" aria-selected="true"> <i
                        class="fa fa-cc-stripe" aria-hidden="true"></i> Bank</a>
            </li>
        @endif
        @if($a_setting && $a_setting->paypal_is_enable)
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="paypal" data-toggle="pill" href="#paypal-form" role="tab" aria-selected="false"> <i
                        class="fa fa-paypal" aria-hidden="true"></i> Paypal </a>
            </li>
        @endif


            <li class="nav-item" role="presentation">
                <a class="nav-link" id="payoneer" data-toggle="pill" href="#payoneer-form" role="tab" aria-selected="false">
                    <i class="fa fa-paypal" aria-hidden="true"></i> Payoneer </a>
            </li>

        @if($a_setting && $a_setting->j_is_enable)
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="Jazzcash" data-toggle="pill" href="#jazzcash_form" role="tab" aria-selected="false">
                    <i class="fa fa-fighter-jet" aria-hidden="true"></i> JazzCash </a>
            </li>
        @endif
        @if($a_setting && $a_setting->e_is_enable)
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="easypaisa" data-toggle="pill" href="#easypaisa_form" role="tab"
                aria-selected="false"> <i class="fa fa-etsy" aria-hidden="true"></i> EasyPaisa </a>
        </li>
        @endif
    </ul>

    <div class="tab-content" id="payment-optionsContent">
        @if($offline_setting && $offline_setting->b_is_enable)
        <div class="tab-pane fade show " id="bank-form" role="tabpanel" aria-labelledby="bank">
            <section>
                <h2> Bank </h2>
                <hr />
                @include('session_msg')
                <form action="{{route('i_bank_payment')}}" method="post">
                    @csrf
                    <div class="row my-5">
                        <div class="col-md-4">
                            <label for="b_name"> Bank Name </label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control hide @error('b_name') is-invalid @enderror"
                                id="b_name" value="@if(isset($setting)){{ $setting->b_name ?? '' }}@endif" name="b_name"
                                placeholder="Bank Name">
                            @error('b_name')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label for="b_swift_code"> Bank swift code </label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control hide @error('b_swift_code') is-invalid @enderror"
                                id="b_swift_code" value="@if(isset($setting)){{ $setting->b_swift_code ?? '' }}@endif"
                                name="b_swift_code" placeholder="Swift Code">
                            @error('b_swift_code')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label for="b_account_name"> Bank Account Name </label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control hide @error('b_account_name') is-invalid @enderror"
                                id="b_account_name"
                                value="@if(isset($setting)){{ $setting->b_account_name ?? '' }}@endif"
                                name="b_account_name" placeholder="Account Name">
                            @error('b_account_name')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label for="b_account_no"> Bank Account Number </label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control hide @error('b_account_no') is-invalid @enderror"
                                id="b_account_no" value="@if(isset($setting)){{ $setting->b_account_no ?? '' }}@endif"
                                name="b_account_no" placeholder="Account Number">
                            @error('b_account_no')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label for="b_branch_name"> Bank Branch Name </label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control hide @error('b_branch_name') is-invalid @enderror"
                                id="b_branch_name" value="@if(isset($setting)){{ $setting->b_branch_name ?? '' }}@endif"
                                name="b_branch_name" placeholder="Branch Name">
                            @error('b_branch_name')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label for="b_branch_addr"> Bank Branch Address </label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control hide @error('b_branch_addr') is-invalid @enderror"
                                id="b_branch_addr" value="@if(isset($setting)){{ $setting->b_branch_addr ?? '' }}@endif"
                                name="b_branch_addr" placeholder="Branch address">
                            @error('b_branch_addr')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label for="b_iban"> Bank IBAN </label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control hide @error('b_iban') is-invalid @enderror"
                                id="b_iban" value="@if(isset($setting)){{ $setting->b_iban ?? '' }}@endif" name="b_iban"
                                placeholder="Branch Name">
                            @error('b_iban')
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

            <section class="my-5">
                @if(isset($min_bank_limit) && $min_bank_limit->b_min)
                    <h3> Minimum Withdraw Requirement </h3>
                    <hr>
                    <div> Min Withdraw PKR {{ $min_bank_limit->b_min ?? '' }} </div>
                    @if($min_bank_limit->b_note)
                        <div> {{ $min_bank_limit->b_note ?? '' }} </div>
                    @endif
                @endif
            </section>
        </div>
        @endif
        @if($a_setting && $a_setting->paypal_is_enable)

        <div class="tab-pane fade show" id="paypal-form" role="tabpanel" aria-labelledby="paypal">
            <section>
                <h2> Paypal </h2>
                <hr />
                @include('session_msg')
                <form action="{{route('i_paypal_payment_withdraw')}}" method="post">
                    @csrf
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label for="paypal_account"> Paypal Email </label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control hide @error('paypal_account') is-invalid @enderror"
                                id="paypal_account" name="paypal_account"
                                value="@if(isset($setting)){{  $setting->paypal_account ?? '' }}@endif"
                                placeholder="Paypal Email" />
                            @error('paypal_account')
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

            <section>
                @if(isset($min_bank_limit) && $min_bank_limit->p_min)
                    <h3> Minimum Withdraw Requirement </h3>
                    <hr>
                    <div> Min Withdraw ${{ $min_bank_limit->p_min ?? '' }} </div>
                    @if($min_bank_limit->p_note)
                        <div> {{ $min_bank_limit->p_note ?? '' }} </div>
                    @endif
                @endif
            </section>
        </div>
        @endif
        <div class="tab-pane fade show" id="payoneer-form" role="tabpanel" aria-labelledby="payoneer">
            <section>
                <h2> Payoneer </h2>
                <hr />
                @include('session_msg')
                <form action="{{route('i_payoneer_payment_withdraw')}}" method="post">
                    @csrf

                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label for="payoneer_account"> Payoneer Email </label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control hide @error('payoneer_account') is-invalid @enderror"
                                id="payoneer_account" name="payoneer_account"
                                value="@if(isset($setting)){{  $setting->payoneer_account ?? '' }} @else {{old('payoneer_account') }} @endif"
                                placeholder="Payoneer Email" />
                            @error('payoneer_account')
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

            <section class="my-5">
                @if(isset($min_bank_limit) && $min_bank_limit->p_min)
                    <h3> Minimum Withdraw Requirement </h3>
                    <hr>
                    <div> Min Withdraw $ {{ $min_bank_limit->p_min ?? '' }} </div>
                    @if($min_bank_limit->p_note)
                        <div> {{ $min_bank_limit->p_note ?? '' }} </div>
                    @endif
                @endif
            </section>
        </div>
        @if($a_setting && $a_setting->j_is_enable)

        <div class="tab-pane fade show" id="jazzcash_form" role="tabpanel" aria-labelledby="Jazzcash">
            <section>
                <h2> Jazzcash </h2>
                <hr />
                @include('session_msg')
                <form action="{{route('i_jazzcash_payment_withdraw')}}" method="post">
                    @csrf
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label for="j_account"> Jazzcash Mobile Account </label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control hide @error('j_account') is-invalid @enderror"
                                id="j_account" name="j_account"
                                value="@if(isset($setting)){{$setting->j_account ?? '' }}@else {{ old('j_account') }} @endif"
                                placeholder="Jazzcash Mobile Account" />
                            @error('j_account')
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

            <section class="my-5">
                @if(isset($min_bank_limit) && $min_bank_limit->j_min)
                    <h3> Minimum Withdraw Requirement </h3>
                    <hr>
                    <div> Min Withdraw PKR {{ $min_bank_limit->j_min ?? '' }} </div>
                    @if($min_bank_limit->j_note)
                        <div> {{ $min_bank_limit->j_note ?? '' }} </div>
                    @endif
                @endif
            </section>
        </div>
        @endif
        @if($a_setting && $a_setting->e_is_enable)

        <div class="tab-pane fade show" id="easypaisa_form" role="tabpanel" aria-labelledby="easypaisa">
            <section>
                <h2> Easypaisa </h2>
                <hr />
                @include('session_msg')
                <form action="{{route('i_easypaisa_payment_withdraw')}}" method="post">
                    @csrf

                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label for="e_account"> Easypaisa Mobile Account </label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control hide @error('e_account') is-invalid @enderror"
                                id="e_account" name="e_account"
                                value="@if(isset($setting)){{$setting->e_account ?? ''}}@else{{old('e_account')}}@endif"
                                placeholder="Easypaisa Mobile Account" />
                            @error('e_account')
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

            <section class="my-5">
                @if(isset($min_bank_limit) && $min_bank_limit->e_min)
                    <h3> Minimum Withdraw Requirement </h3>
                    <hr>
                    <div> Min Withdraw PKR {{ $min_bank_limit->e_min ?? '' }} </div>
                    @if($min_bank_limit->e_note)
                        <div> {{ $min_bank_limit->e_note ?? '' }} </div>
                    @endif
                @endif
            </section>

        </div>
        @endif
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
              case '#payoneer-form':                
                  $('#payoneer').addClass('active');
                  $(hash).addClass('active');
                break;
              case '#jazzcash_form':                
                  $('#Jazzcash').addClass('active');
                  $(hash).addClass('active');
                break;
              case '#easypaisa_form':                
                  $('#easypaisa').addClass('active');
                  $(hash).addClass('active');
                break;
            
              default:
                    if($('#bank').length){
                        $('#bank , #bank-form').addClass('active');                  
                    }else{
                        $('#payoneer, #payoneer-form').addClass('active');
                    }
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