@extends('admin.admin_main')


@section('content')
    <h1> Categories </h1> 
    <p> Select your category and apply your operations </p>

    <div class="row">
        <div class="col-md-6">
            <div class="jumbotron text-center bg-light">
                <a href="{{route('admin_main_categories')}}" class="btn website-outline btn-lg ">
                    Main Category 
                </a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="jumbotron text-center bg-light">
                <a href="{{route('admin_sub_categories')}}" class="btn website-outline btn-lg ">
                    Sub Categories
                </a>
            </div>
        </div>
    </div>
@endsection 


@section("page-js")
    <script>
         $('#a_c').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');
    </script>
@endsection 