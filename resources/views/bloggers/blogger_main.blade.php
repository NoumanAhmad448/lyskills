<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>  @if(isset($title)) {{ $title }} @else {{ __('Blogger') }} @endif </title>            
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="shortcut icon" href="{{asset('img/favicon.png')}}">

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
            integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" 
            crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">

    @livewireStyles
    @yield('page-css')
</head>
<body style="font-family: 'Roboto', sans-serif;'">
    <nav class="navbar bg-info">
        <a class="navbar-brand text-white" href="{{route('blogger_home')}}"> 
            {{-- <img src="{{asset('img/logo.jpg')}}" alt="lyskills" class="img-fluid" width="60"/> --}}
            Lyskills
         </a>            
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">        
                <a class="nav-link text-white" href="{{route('index')}}" target="_blank"> 
                    <i class="fa fa-home" aria-hidden="true"></i> Home </a>
            </li>   
        </ul>        
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link text-white" href="{{route('b_logout')}}"> 
                    <i class="fa fa-sign-out" aria-hidden="true"></i> Logout </a>
            </li>   
        </ul>    
    </nav>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-3">
                <ul class="list-group list-group-flush">
                    @if(isset($setting) && $setting->isBlog)
                         <li class="list-group-item"><a href="{{route('blogger_v_p')}}"> Blogger </a>  </li> 
                    @endif
                    @if(isset($setting) && $setting->isFaq) 
                        <li class="list-group-item"> <a href="{{route('blogger_v_faq')}}"> FAQ </a> </li>                   
                    @endif
                  </ul>
            </div>
        
            <div class="col-md-9">
                @yield('content')
            </div>

        </div>
    </div>
    @livewireScripts
    @yield('page-js')
    </body>
</html>
