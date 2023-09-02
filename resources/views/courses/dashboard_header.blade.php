<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> @if(isset($title)){{ $title }} @else {{ config('app.name') }} @endif </title>        
    <meta name="description" content="@if(isset($desc)) {{ $desc }} @else {{__('description.default')}}  @endif">
    <meta property="og:title" content="@if(isset($title)){{ $title }} @else {{ config('app.name') }} @endif">
    <meta property="og:description" content="@if(isset($desc)) {{ $desc }} @else {{__('description.default')}}  @endif">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="shortcut icon" href="{{asset('img/favicon.png')}}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <title> @if(! empty($title)) {{$title}} @else {{ get_option('site_title') }} @endif</title> --}}

    <!-- all css here -->
    @yield('page-css')
    <!-- bootstrap v4.5.3 css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/text.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css"
    integrity="sha512-vebUliqxrVkBy3gucMhClmyQP9On/HAWQdKDXRaAlb/FKuTbxkjPKUyqVOxAcGwFDka79eTF+YXwfke1h3/wfg=="
    crossorigin="anonymous" />

    <?php
    if($_SERVER['SERVER_NAME'] == 'lyskills.org'){
        echo '<meta name="robots" content="noindex">';
    }

    ?>
    {{-- jquery --}}
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js" --}}
    {{-- integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>  --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
     crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
     integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script src="{{ asset('js/common_functions.js') }}">
    </script>
    <script>
    $(function () {
    $('.date-picker').datepicker({
            dateFormat: 'yy-mm-dd',
            onClose: function(dateText, inst) {
            $(this).datepicker('option', 'dateFormat', 'yy-mm-dd');
        }
    }
    );
    });
</script>
</head>
<body class="min-vh-100 d-flex flex-column">
    @include("modals.modal")
    <nav class="navbar navbar-dark bg-website text-white d-flex justify-content-between p-3">
        <div class="d-flex">
            <a href="{{route('dashboard')}}" class="text-white"> <i class="las la-angle-left"></i> <span class="d-none d-md-inline"> back to dashboard </span> </a>
            <div class="ml-3 text-uppercase"> {{$course->course_title ?? ''}} </div>
             @php try {
                 $status = $course->status;
              }
              catch(Exception $e){
                  echo 'Database error';
              }
              @endphp
            <div class="ml-3 badge 
                @if($status == 'draft') {{ __('badge-warning') }}  @elseif($status == 'published') {{ __('badge-success')}}
                @elseif($status == 'pending') {{ __('badge-info')}} 
                @elseif($status == 'block') {{ __('badge-danger')}} 
                @elseif($status == 'unpublished') {{ __('badge-danger')}} 
                @endif"> 
                {{ $status ?? ''}} 
            </div>
        </div>
        <div class="d-flex">
            @if($course->slug)
                <a class="btn btn-info border mr-5" href="{{route('user-course',['slug' => $course->slug])}}">
                    Preview 
                </a>
            @endif
            @if(isset($course) && $course)
                <a href="{{route('setting', ['course' => $course->id ])}}" class="text-white icon-sm"> <i class="las la-cog"></i> </a>
            @endif
        </div>
    </nav>




