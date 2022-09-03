<div>
    @php 
    use Illuminate\Support\Str;
    @endphp
    <h1> Edit Blogger </h1>
    <hr/>
    <div class="d-flex justify-content-end">
        <a href="{{route('show_blogger___')}}" class="btn btn-info btn-lg">Show Bloggers </a>
    </div>
    
    @if (isset($user) && $user)
        
    
        @include('session_msg')
        <form action="{{route('update_blogger___',compact('user'))}}" method="POST">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-md-6 offset-md-3">                
            <div class="form-group">
            <label for="name"> 
                Name
            </label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" aria-describedby="blogger name"
                    placeholder="Blogger Name" value="{{$user->name ?? ''}}" 
                    >        
            </div>
            @error('name')
                <div class="alert alert-danger"> {{ $message }} </div>
            @enderror

            <div class="form-group">
            <label for="email"> User Name</label>          
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="email" name="email" placeholder="username" aria-label="username"
                value="{{Str::of($user->email)->explode('@')[0] ?? ''}}"
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
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" aria-describedby="Password"
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
            
            <button type="submit" class="btn btn-outline-info"> Update Profile </button>
        </form> 
      @endif


    </div>
