@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('img')
 <img src="{{asset('img/403.jpg')}}" alt="lyskills-403 forbidden" class="img-fluid w-50"/>
 @endsection

@section('code')
    <div class="display-3"> 403 forbidden request </div>
@endsection

@section('message')
 <div class="mt-3"> You are not allowed to visit this URL or perform this action. Please contact with us, if you think
     you are here because of any mistake. 
 </div>
 <a href="{{route('index')}}" class="btn btn-primary my-3"> Home Page </a>
 @endsection
