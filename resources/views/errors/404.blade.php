@extends('errors::minimal')

@section('title', __('404 Not Found'))
@section('code')
<div class="display-2"> 404 page not found </div>

@endsection

@section('img')
    <img src="{{ asset('img/404.jpg')}}" alt="404" class="img-fluid w-70" />
@endsection
@section('message')

<div class="mt-3"> we cannot find this page on our website. Please check the spelling in the URL. This might be possible, 
    this page has been removed due to some reason so please try visiting other URL, if this page does not show 
    you now
</div>
<a href="{{route('index')}}" class="btn btn-primary mt-3"> Home Page </a>

@endsection
