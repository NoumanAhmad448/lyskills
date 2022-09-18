@extends(config('setting.guest_blade'))
@section('content')

<div class="jumbotron bg-static-website text-center text-white text-uppercase">
    <h1> {{ $page->title ?? '' }} </h1>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            {!! $page->message !!}
        </div>
    </div>
</div>



@endsection