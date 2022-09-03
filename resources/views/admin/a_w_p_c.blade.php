@extends('admin.admin_main')


@section('page-css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
  <h1> Withdraw Rules</h1>
  <hr/>
  <ul class="nav nav-pills mb-3" id="payment-options" role="tablist">
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="bank" data-toggle="pill" href="#bank-form" role="tab" 
      aria-selected="true"> <i class="fa fa-cc-stripe" aria-hidden="true"></i>  Bank</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="paypal" data-toggle="pill" href="#paypal-form" role="tab" 
      aria-selected="false"> <i class="fa fa-paypal" aria-hidden="true"></i> Paypal </a>
    </li>   
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="Jazzcash" data-toggle="pill" href="#jazzcash_form" role="tab" 
      aria-selected="false"> <i class="fa fa-fighter-jet" aria-hidden="true"></i> JazzCash </a>
    </li>   
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="easypaisa" data-toggle="pill" href="#easypaisa_form" role="tab" 
      aria-selected="false"> <i class="fa fa-etsy" aria-hidden="true"></i> EasyPaisa </a>
    </li>   
  </ul>

    <div class="tab-content" id="payment-optionsContent">
      <div class="tab-pane fade show " id="bank-form" role="tabpanel" aria-labelledby="strip">
        <section>
          <h2> Bank </h2>
          <hr/>
          @include('session_msg')
          <form action="{{route('a_withdraw_bank')}}" method="post">
            @csrf
            <div class="row">
              <div class="col-md-4">
                  <label for="b_min"> Minimum Amount  </label>
              </div>
              <div class="col-md-6">                
                  <input type="text" class="form-control @error('b_min') is-invalid @enderror" id="b_min"
                    value="@if(isset($withdraw)){{ $withdraw->b_min ?? '' }}@endif"
                  name="b_min"  placeholder="minimum amount"> 
                  @error('b_min')
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
                  rows="10"
                  placeholder="note">@if(isset($withdraw)){{$withdraw->b_note ?? '' }}@endif</textarea>                                  
                  @error('b_note')
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
      
      <div class="tab-pane fade show" id="paypal-form" role="tabpanel"  aria-labelledby="paypal" >
        <section>
            <h2> Paypal </h2>
            <hr/>
            @include('session_msg')
            <form action="{{route('a_withdraw_paypal')}}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-4">
                    <label for="p_min"> Minimum Amount  </label>
                </div>
                <div class="col-md-6">                
                    <input type="text" class="form-control @error('p_min') is-invalid @enderror" id="p_min"
                      value="@if(isset($withdraw)){{ $withdraw->p_min ?? '' }}@endif"
                    name="p_min"  placeholder="minimum amount"> 
                    @error('p_min')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror                                 
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-md-4">
                    <label for="p_note"> Note  </label>
                </div>
                <div class="col-md-6">                
                    <textarea class="form-control @error('p_note') is-invalid @enderror" id="p_note" name="p_note"                   
                    rows="10"
                    placeholder="note">@if(isset($withdraw)){{$withdraw->p_note ?? '' }}@endif</textarea>                                  
                    @error('p_note')
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
      
      <div class="tab-pane fade show" id="jazzcash_form" role="tabpanel"  aria-labelledby="Jazzcash">
        <section>
            <h2> JazzCash </h2>
            <hr/>
            @include('session_msg')
            <form action="{{route('a_withdraw_jazz')}}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-4">
                    <label for="j_min"> Minimum Amount  </label>
                </div>
                <div class="col-md-6">                
                    <input type="text" class="form-control @error('j_min') is-invalid @enderror" id="j_min"
                      value="@if(isset($withdraw)){{ $withdraw->j_min ?? '' }}@endif"
                    name="j_min"  placeholder="minimum Amount"> 
                    @error('j_min')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror                                 
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-md-4">
                    <label for="j_note"> Note  </label>
                </div>
                <div class="col-md-6">                
                    <textarea class="form-control @error('j_note') is-invalid @enderror" id="j_note" name="j_note"                   
                    rows="10"
                    placeholder="note">@if(isset($withdraw)){{$withdraw->j_note ?? '' }}@endif</textarea>                                  
                    @error('j_note')
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
      
      <div class="tab-pane fade show" id="easypaisa_form" role="tabpanel"  aria-labelledby="easypaisa">
        <section>
            <h2> Easypaisa </h2>
            <hr/>
            @include('session_msg')
            <form action="{{route('a_withdraw_easypaisa')}}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-4">
                    <label for="e_min"> Minimum Amount  </label>
                </div>
                <div class="col-md-6">                
                    <input type="text" class="form-control @error('e_min') is-invalid @enderror" id="e_min"
                      value="@if(isset($withdraw)){{ $withdraw->e_min ?? '' }}@endif"
                    name="e_min"  placeholder="minimum amount"> 
                    @error('e_min')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror                                 
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-md-4">
                    <label for="e_note"> Note  </label>
                </div>
                <div class="col-md-6">                
                    <textarea class="form-control @error('e_note') is-invalid @enderror" id="e_note" name="e_note"                   
                    rows="10"
                    placeholder="note">@if(isset($withdraw)){{$withdraw->e_note ?? '' }}@endif</textarea>                                  
                    @error('e_note')
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
          $('#a_w_p_c').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');  
          
          var resetValues = (current_obj) =>{
                $('.alert').fadeOut();
                current_obj.removeClass('is-invalid');
            }

            let values = $('input, textarea');
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
              case '#jazzcash_form':                
                  $('#Jazzcash').addClass('active');
                  $(hash).addClass('active');
                break;
              case '#easypaisa_form':                
                  $('#easypaisa').addClass('active');
                  $(hash).addClass('active');
                break;
            
              default:
                  $('#bank , #bank-form').addClass('active');                  
                break;
            }
      });


      </script>
@endsection