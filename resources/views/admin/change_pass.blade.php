@extends('admin.admin_main')


@section('content')

    <h1> Change Password </h1>
    <hr/>
    @include('session_msg')
    <form action="{{route('admin_p_change_pass')}}" method="post">
        @csrf
        @method('patch')
        <div class="form-group">
            <label for="pass"> Password </label>
            <div class="input-group mb-3">
                <input type="password" class="form-control @error('pass') is_invalid @enderror" id="pass" name="pass"
                    value="{{old('pass')}}" placeholder="Password">                        
                    <div class="input-group-append">
                <span class="input-group-text cursor_pointer" id="show_p"><i class="fa fa-eye" aria-hidden="true"></i>
                </span>
            </div> 
                    
        </div>
        @error('pass')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror 
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="password">New Password </label>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('c_pass') is_invalid @enderror" id="c_pass" 
                                    name="c_pass" placeholder="New Password"
                            value="{{old('c_pass')}}">
                        <span class="input-group-text cursor_pointer" id="show_c_p"><i class="fa fa-eye" aria-hidden="true"></i>
                        </span>
                    </div>   
                    @error('c_pass')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>                
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="c_pass_2"> Confirm Password </label>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" id="c_pass_2" name="c_pass_2" placeholder="Confirm Password" 
                                value="{{old('c_pass_2')}}"
                        />   
                        <span class="input-group-text cursor_pointer" id="show_c_p2"><i class="fa fa-eye" aria-hidden="true"></i>
                        </span>
                    </div>     
                    @error('c_pass_2')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-info"> <i class="fa fa-floppy-o" aria-hidden="true"></i> Update </button>
    </form>
@endsection



@section('page-js')
    <script>    
       $(function(){

            var showPassword = (pass) => {
                if(pass.attr('type') === "password"){
                    pass.attr('type','text');
                }else{
                    pass.attr('type','password');
                }
            }

            var pass = $('#show_p');
            pass.click(function(){
                var other_el = $('#pass');
                showPassword(other_el);
            });

            var c_pass = $('#show_c_p');
            c_pass.click( () => {
                let other_el = $('#c_pass');
                showPassword(other_el);
            });

            var c_pass = $('#show_c_p2');
            c_pass.click( () => {
                let other_el = $('#c_pass_2');
                showPassword(other_el);
            });

            setTimeout(() => {
                $('.alert').fadeOut();
            }, 5000);

       });
    </script>
@endsection