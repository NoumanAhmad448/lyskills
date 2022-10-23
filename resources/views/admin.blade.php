<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
    <link rel="shortcut icon" href="{{asset('img/favicon.png')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" i
        ntegrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    {{-- <link rel="preconnect" href="https://fonts.gstatic.com"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
     crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/text.css')}}">

</head>
<body class="bg-white" style="font-family: roboto;">
    
    <div class="mt-5">
        <div class="d-flex justify-content-center">
            <a href="{{route('index')}}" class="bg-white">
                <img src="{{asset('img/logo.jpg')}}" alt="lyskills" class="img-fluid" width="100"/>
            </a>
        </div>
        @include('session_msg')
        <div class="d-flex justify-content-center">
            <form action="{{route('admin_a')}}" method="post">
                @csrf
                <div class="form-group">
                  <label for="user_name">Username</label>
                  <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" id="email" placeholder="UserName">  
                    <div class="mt-1">
                        @error('email')
                            <div class="alert alert-danger r_err">{{ $message }}</div>
                        @enderror         
                    </div>      
                </div>
                
                <div class="form-group">
                  <label for="pass">Password</label>
                   <div class="input-group mb-3">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                              placeholder="Password">
                     <div class="input-group-append">
                      <span class="input-group-text bg-info cursor-pointer cursor_pointer text-white" id="show_pass"><i class="fa fa-eye" aria-hidden="true"></i>
                                 </span>
                    </div>
                  </div>
                  <div class="mt-1">
                    @error('password')
                        <div class="alert alert-danger r_err">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="form-group mt-3">                
                    {!! NoCaptcha::renderJs() !!}
                    {!! NoCaptcha::display() !!}
                    @error('g-recaptcha-response')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-info">Login</button>
                <a href="{{route('index')}}" class="text-info ml-3"> Visit Lyskills </a>
              </form>
        </div>
        
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(function(){
            $('input').keyup(function(){
                $('.r_err').addClass('d-none');
                $(this).removeClass('is-invalid');
            });

            setTimeout(() => {
                $('.alert').fadeOut();                
                $('input').removeClass('is-invalid');
            }, 5000);
            

            $("input").click( ()=>{
                $('.alert').fadeOut();
                $('input').removeClass('is-invalid');
            });

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
</body>
</html>