<div>
    @section('page-css')
        @livewireStyles
        <meta name="csrf-token" content="{{ csrf_token() }}">

    @endsection
    <h1>
        Create Admin 
    </h1>
    <hr/>
    <div class="d-flex justify-content-end">
        <a href="{{route('show_sub_admins')}}" class="btn btn-lg btn-info"> Show All Admin </a>
    </div>
    @include('session_msg')
    <form action="{{route('store_admin')}}" method="POST">
        @csrf
        
        <div class="row">
            <div class="col-md-6 offset-md-3">                
        <div class="form-group">
          <label for="name"> 
              Name
          </label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" aria-describedby="name"
                placeholder="Name" value="{{old('name')}}" 
                >        
        </div>
        @error('name')
            <div class="alert alert-danger"> {{ $message }} </div>
        @enderror

        <div class="form-group">
          <label for="email"> User Name</label>          
          <div class="input-group mb-3">
            <input  type="text" class="form-control" id="email" name="email" placeholder="username" aria-label="username"
            value="{{old('email')}}"
            >
            <div class="input-group-append">
              <span class="input-group-text text-white bg-info" >@lyskills.com</span>
            </div>            
          </div>
        </div>

        @error('email')
            <div class="alert alert-danger"> {{ $message }} </div>
        @enderror
        
        <div class="form-group">
            <label for="password"> 
                Password
            </label>
            <div class="input-group mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                    name="password" id="password" aria-describedby="Password"
                    placeholder="Password"  
                    >        
                <div class="input-group-append">
                <span class="input-group-text text-white bg-info" id="show-pass"><i class="fa fa-eye" aria-hidden="true"></i>
                </span>
                </div>            
            </div>
        </div>
        @error('password')
            <div class="alert alert-danger"> {{ $message }} </div>
        @enderror
        
        <button type="submit" class="btn btn-outline-info"> Create Admin </button>
      </form>      
        </div>
    </div>
    @section('page-js')
        @livewireScripts
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

                var pass = $('#show-pass');
                pass.click(function(){
                    var other_el = $('#password');
                    showPassword(other_el);
                });                
            });
        </script>
    @endsection
</div>
