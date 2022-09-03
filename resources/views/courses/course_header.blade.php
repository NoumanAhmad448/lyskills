<!DOCTYPE html>
<html>

<head>
    <title> course overview </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300&display=swap" rel="stylesheet">
    
    <title> @if(isset($title)){{ $title }} @else {{ config('app.name') }} @endif </title>        
    <meta name="description" content="@if(isset($desc)) {{ $desc }} @else {{__('description.default')}}  @endif">
    <meta property="og:title" content="@if(isset($title)){{ $title }} @else {{ config('app.name') }} @endif">
    <meta property="og:description" content="@if(isset($desc)) {{ $desc }} @else {{__('description.default')}}  @endif">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="shortcut icon" href="{{asset('img/favicon.png')}}">

    
    @yield('course_css')



</head>
<body>
@yield('course_content')


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
@yield('course_footer')
</body>
</html>
