<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> @if(isset($title)){{ __('messages.'.$title) }} @else {{ __("messages.admin") }} @endif </title>        
    <meta name="description" content="@if(isset($desc)) {{ $desc }} @else {{__('description.default')}}  @endif">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="shortcut icon" href="{{asset('img/favicon.png')}}">
    <?php 
    if($_SERVER['SERVER_NAME'] == 'lyskills.org'){        
        echo '<meta name="robots" content="noindex">';
    }

    ?>
    <link rel="stylesheet" href="{{asset('css/text.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
            integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" 
            crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">

    @yield('page-css')
</head>
<body class="d-flex flex-column" style="min-height: 90%">
    <nav class="navbar bg-website">
        <a class="navbar-brand text-white" href="{{route('a_home')}}"> 
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
                <a class="nav-link text-white" href="{{route('a_logout')}}"> 
                    <i class="fa fa-sign-out" aria-hidden="true"></i> Logout </a>
            </li>   
        </ul>    
    </nav>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-3">
                <i class="fa fa-bars d-md-none" aria-hidden="true" id="hamburger"></i>
                <ul class="nav flex-column d-none d-md-block border-right" id="side_menu">
                    <li class="nav-item">
                        <a class="nav-link text-dark " id="users" href="{{route('a_users')}}"> <i class="fa fa-users" aria-hidden="true"></i>
                            Users </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark " href="{{route('a-asses')}}" id="asses"><i class="fa fa-book" aria-hidden="true"></i>
                            Assignments </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark " href="{{route('a_courses')}}" id="courses"> <i class="fa fa-video-camera" aria-hidden="true"></i>
                             Courses </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark " href="{{route('course-enrollment')}}" id="enrollment"> <i class="fa fa-book" aria-hidden="true"></i>
                             Enrollments </a>
                    </li>
                    <hr/>
                    <li class="nav-item">
                        <a class="nav-link text-dark " href="{{route('admin_v_p')}}" id="a_post"> 
                            <i class="fa fa-comments-o" aria-hidden="true"></i>
                             Posts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{route('admin_v_page')}}" id="a_page"> 
                            <i class="fa fa-file-text" aria-hidden="true"></i>
                             Pages
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark " href="{{route('admin_v_faq')}}" id="a_faq"> 
                            <i class="fa fa-question-circle" aria-hidden="true"></i>
                             FAQs
                        </a>
                    </li>
                    <hr/>
                    <li class="nav-item">
                        <a class="nav-link text-dark " href="{{route('admin_view_categories')}}" id="a_c"> 
                            <i class="fa fa-filter" aria-hidden="true"></i>
                             Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark " href="{{route('admin_show_medias')}}" id="a_media"> 
                            <i class="fa fa-video-camera" aria-hidden="true"></i>
                            Media Manager
                        </a>
                    </li>
                    <li class="nav-item">
                        <div class="nav-link text-dark cursor_pointer" id="a_setting"> <i class="fa fa-cog" aria-hidden="true"></i>
                            Setting 
                        </div>
                        <ul class="list-unstyled ml-3 d-none s_sub_menu">
                            <hr/>
                            <li class="nav-item">
                                <a class="nav-link text-dark " href="{{route('admin_g_setting')}}" id="a_g_setting"> 
                                    <i class="fa fa-wrench" aria-hidden="true"></i>
                                    General Setting
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark " href="{{route('admin_lms_setting')}}" id="a_lms_setting"> 
                                    <i class="fa fa-commenting-o" aria-hidden="true"></i>
                                    LMS Setting
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark " href="{{route('a_share_payment')}}" id="a_share_payment"> 
                                    <i class="fa fa-money" aria-hidden="true"></i>
                                    Payment Share Setting
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark " href="{{route('a_payment_gateways')}}" id="a_payment_gateways"> 
                                    <i class="fa fa-university" aria-hidden="true"></i>
                                        Payment Gateways
                                </a>
                            </li>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark " href="{{route('a_offline_payment_gateways')}}" id="a_offline_payment_gateways"> 
                                    <i class="fa fa-address-card" aria-hidden="true"></i>
                                        Offline Payment 
                                </a>
                            </li>
                            <li class="nav-item">                                
                                <a class="nav-link text-dark " href="{{route('a_w_p_c')}}" id="a_w_p_c"> 
                                    <i class="fa fa-university" aria-hidden="true"></i>
                                        Withdraw Rules
                                </a>
                            </li>
                            <li class="nav-item">                                
                                <a class="nav-link text-dark " href="{{route('social_networks')}}" id="social_networks"> 
                                    <i class="fa fa-share-square-o" aria-hidden="true"></i>
                                        Social credentials
                                </a>
                            </li>
                            <li class="nav-item">                                
                                <a class="nav-link text-dark " href="{{route('blogger-setting')}}" id="blogger-setting"> 
                                    <i class="fa fa-share-square-o" aria-hidden="true"></i>
                                        Blogger Setting 
                                </a>
                            </li>
                        </ul>
                    </li>
                    <hr/>
                    <li class="nav-item">
                        <a class="nav-link text-dark " href="{{route('i_new_courses')}}" id="i_new_courses"> 
                            <i class="fa fa-university" aria-hidden="true"></i>
                                    Pending Courses
                        </a>
                    </li>
                    <li class="nav-item">                        
                        <a class="nav-link text-dark " href="{{route('u_payment')}}" id="u_payment">
                            <i class="fa fa-unlock-alt" aria-hidden="true"></i>  
                            User Payments
                        </a>                        
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark " href="{{route('i_payment')}}" id="instructor_payment"> 
                            <i class="fa fa-users" aria-hidden="true"></i>
                                    Instructor Payments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark " href="{{route('n_en')}}" id="n_en"> 
                            <i class="fa fa-users" aria-hidden="true"></i>
                                    New Enrollment
                        </a>
                    </li>
                    <hr/>
                    <li class="nav-item">
                        <a class="nav-link text-dark " href="{{route('s_info')}}" id="s_info"> 
                            <i class="fa fa-users" aria-hidden="true"></i>
                                    Instructor Announcement
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark " href="{{route('s_info_user')}}" id="s_info_user"> 
                            <i class="fa fa-users" aria-hidden="true"></i>
                                    User Announcement
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark " href="{{route('show_blogger___')}}" id="show_blogger"> 
                            <i class="fa fa-users" aria-hidden="true"></i>
                                    Bloggers
                        </a>
                    </li>
                    <hr/>
                    <li class="nav-item">
                        <a class="nav-link text-dark " href="{{route('show_sub_admins')}}" id="show_sub_admins"> 
                            <i class="fa fa-users" aria-hidden="true"></i>
                                    Admins
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark " href="{{route('a-send-email')}}" id="show_sub_admins"> 
                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                            Email
                        </a>
                    </li>
                    <hr/>
                    <li class="nav-item">
                        <a class="nav-link text-dark " href="{{route('admin_change_pass')}}" id="a_c_password"> 
                            <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                               Change Password
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark " href="{{route('a_logout')}}"> 
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                               Logout
                        </a>
                    </li>
                </ul>
            </div>
    
            <div class="col-md-9">
                @yield('content')                
            </div>
        </div>
    </div>
    
    @yield('footer')

    
