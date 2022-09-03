<div>
    
    <div class="d-flex justify-content-center">
        <div class="card mt-5" style="width: 30rem;padding: 11rem 0px" >            
            <a href="{{route('index')}}" class="bg-white card-img-top text-center">
                <img src="{{asset('img/logo.jpg')}}" alt="lyskills" class="img-fluid" width="100"/>
            </a>            
            <div class="card-body">
              <h3 class="card-title text-center"> Blogger Login </h3>
              
        @include('session_msg')
            <div class="mt-5 d-flex justify-content-center">
                <form action="{{route('blogger_login_post')}}" method="post" style="width: 20rem">
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
                <button type="submit" class="btn btn-info">Login</button>
                <a href="{{route('index')}}" class="text-info ml-3"> Visit Lyskills </a>
              </form>
            </div>
        </div>
        
    </div>
</div>
        
    </div>


    @section('page-js')        
    
        <script>
            $(function(){
                $('input').keyup(function(){
                    $('.r_err').addClass('d-none');
                    $(this).removeClass('is-invalid');
                });

                setTimeout(() => {
                    let alert = $('.alert');                    
                    if(alert){
                        alert.fadeOut('slow');                
                    }
                    $('input').removeClass('is-invalid');
                }, 5000);
                

                $("input").click( ()=>{
                    let alert = $('.alert');
                    if(alert){
                        alert.fadeOut('slow');                
                    }
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

    @endsection
</div>
