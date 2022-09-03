@extends('errors::minimal')

@section('title', __('500 Server Error'))
@section('img')
    <img src="{{asset('img/500.jpg')}}" alt="lyskills" class="img-fluid w-50"/>
@endsection 
@section('code')
    <div class="display-3" > Server Error  </div>
@endsection 
@section('message')
    <div class="mt-3">
        We are sorry to see to reach at this page. Do not worry, this is not a problem from you side. There is some problem 
        in our website, we are working on it. Meanwhile, if you have anything to inform us further, please feel free to contact us. 
    </div>
    <section class="d-flex justify-content-center mt-3">
        <a href="{{route('index')}}" class="btn btn-primary"> Home Page </a>
        <form action="{{route('back')}}" method="POST">
            @csrf
            <button type="submit" class="btn btn-secondary ml-3"> Go Back </button>
        </form>
    </section>

@endsection 

