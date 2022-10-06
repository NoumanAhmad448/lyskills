@extends(config("setting.guest_blade"))
@section('page-css')
<style>
    a{
        color: #00f;
    }
    </style>
    <meta property="og:type"  content="website" />
    <meta property="og:image" content="@if(isset($c_img) && empty($c_img))  {{asset('img/logo.jpg')}} @else {{ asset('storage/'.$c_img) }} @endif" />
@endsection
@section('content')





<div class="jumbotron mt-35  text-center jumbotron-bg-color border border-light rounded text-uppercase">
    <h1> {{ $faq->title ?? '' }} </h1>
    <div> {{ $faq->created_at ?? ''}} </div>
 </div>

 <div class="container">
     <div class="row">
         <div class="col-md-8 offset-md-2">
             <nav aria-label="breadcrumb">
                 <ol class="breadcrumb">
                     <li class="breadcrumb-item text-primary"><a href="{{ route('public_faq')}}">FAQ</a></li>
                     <li class="breadcrumb-item" aria-current="page"> {{ $faq->slug }}</li>
                 </ol>
               </nav>
             <img src="{{config('setting.s3Url').$faq->upload_img}}" alt="{{ $faq->f_name }}" class="w-100 img-fluid mb-4">
         </div>
         <div class="col-md-8 offset-md-2">
             {!! $faq->message !!}
         </div>
     </div>
 </div>

 <div class="container mb-2 mt-5">
     <div class="row">
         <div class="col-4 offset-2">
             @if(isset($prev) && $prev)  <a href="{{$prev->slug}}" class="btn btn-primary"> Previous FAQ </a> @endif
         </div>
         <div class="col-4">
             <div class="d-flex justify-content-end">
                 @if(isset($next) && $next)  <a href="{{$next->slug}}" class="btn btn-primary"> Next FAQ </a> @endif
             </div>
         </div>
     </div>
 </div>

@endsection