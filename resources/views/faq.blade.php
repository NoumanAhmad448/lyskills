@extends(config('setting.guest_blade'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="jumbotron mt-35  text-center jumbotron-bg-color border border-light rounded text-uppercase">
                    <h1>
                        FAQs
                    </h1>
                </div>
            </div>
        </div>
    </div>
    @if(isset($faqs) && $faqs->count()) 

    @foreach($faqs as $faq)
        <div class="container-fluid">
            <div class="row my-5">
                <div class="col-md-4 offset-md-2">
                    <a href="{{route('public_faqs', ['slug' => $faq->slug])}}"> <img src="{{asset('storage/'.$faq->upload_img)}}" 
                        width="400" height="200"
                        /> </a>
                </div>
                <div class="col-md-6 d-flex align-items-center flex-column">
                    <a href="{{route('public_faqs', ['slug' => $faq->slug])}}" class="text-primary">
                        <h2>
                            {{ $faq->title ?? '' }}
                        </h2>
                    </a>
                    <div>
                        {{ reduceWithStripping($faq->message,250) }}
                        <a href="{{route('public_faqs', ['slug' => $faq->slug])}}" class="badge badge-warning"> Read More </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @else 
    <div class="text-center">
        No Post Available
    </div>
    @endif
@endsection