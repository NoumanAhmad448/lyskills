<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">

<!-- Fonts -->
{{-- <link rel="preconnect" href="https://fonts.gstatic.com"> --}}
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

{{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}

<link rel="stylesheet" href="{{ asset('css/text.css') }}">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
    integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">


{{-- should alway be in the end --}}
<script>
    debug = '{{ config('app.debug') ? 1 : 0 }}';
    debug = debug == "1" ? true : false;
    let err_msg = '{{ config('setting.err_msg') }}';
</script>
<script src='{{ asset('js/common_functions.js')}}'></script>
{{-- should not include after this line --}}
