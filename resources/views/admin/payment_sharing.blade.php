@extends('admin.admin_main')

@section('page-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

    <h1> Payment Sharing Setting </h1>
    <hr/>
    @include('session_msg')
    <form action="{{route('a_p_share_payment')}}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <div>Enable/Disable Payment</div>       
                                       
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="enable" name="enable" 
                        @if(isset($setting) && $setting->payment_share_enable) {{ __('checked')}} @endif >
                        <label class="custom-control-label" for="enable"> Enable/Disable </label>
                    </div>
                    <div class="mt-1">
                        If disabled, all payment will be sent to Instructor
                    </div>
                </div>
            </div>        
        </div>
        <div class="row mt-4">
            <div class="col-md-4">            
                <div for="instructor_share"> Instructor Share </div>                
            
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control @error('instructor_share') is-invalid @enderror" id="instructor_share" 
                    name="instructor_share" placeholder="Instructor Share" value="@if(isset($setting)){{ $setting->instructor_share ?? '' }}@endif" />
                    <div>
                        Payment will be sent to Instructor depending upon the percentage you set above.Make sure to set it less than 
                        100.
                    </div>
                    @error('instructor_share')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror                    
                </div>                
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-4">            
                <div for="admin_share"> Admin Share </div>                
            
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control @error('admin_share') is-invalid @enderror" id="admin_share" 
                            name="admin_share" placeholder="Admin Payment" value="@if(isset($setting)){{ $setting->admin_share ?? '' }}@endif" />
                    <div>
                        Payment will be sent to admin depending upon the percentage you set above. Make sure to set it less than 
                        100.
                    </div>
                    @error('admin_share')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>                
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6 offset-md-4">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary"> 
                        <i class="fa fa-floppy-o" aria-hidden="true"></i>
                          Save 
                    </button>
                </div>                
            </div>
        </div>
        
    </form>

@endsection



@section('page-js')
    <script>         
        
        $(function(){
            $('#a_share_payment').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');   
            var resetValues = (current_obj) =>{
                $('.alert').fadeOut();
                current_obj.removeClass('is-invalid');
            }

            let values = $("#admin_share , #instructor_share");
            setTimeout(() => {
                
                resetValues(values);
            }, 5000);

            values.click(()=>{
                resetValues(values);
            });

            $('.s_sub_menu').removeClass('d-none');

        });
    
    </script>
@endsection