@extends(config('setting.guest_blade'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="jumbotron mt-35  text-center jumbotron-bg-color border border-light rounded text-uppercase">
                    <h1>
                        Posts
                    </h1>
                </div>
            </div>
        </div>
    </div>
    @if(isset($posts) && $posts->count())

    @foreach($posts as $post)
        <div class="container-fluid">
            <div class="row my-5">
                <div class="col-md-4 offset-md-2">
                    <a href="{{route('public_posts', ['slug' => $post->slug])}}"> <img id="post-img" class="" width="" height=""
                        src="{{config('setting.s3Url').$post->upload_img}}"  /> </a>
                </div>
                <div class="col-md-5 d-flex align-items-center flex-column">
                    <a href="{{route('public_posts', ['slug' => $post->slug])}}" class="text-primary">
                        <h2>
                            {{ $post->title ?? '' }}
                        </h2>
                    </a>
                    <div>
                        {{ reduceWithStripping($post->message,250) }}
                        <a href="{{route('public_posts', ['slug' => $post->slug])}}" class="badge badge-warning"> Read More </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="d-flex justify-content-end mb-5 pr-3">
        {{ $posts->links()}}
    </div>
    @else
    <div class="text-center">
        No Post Available
    </div>
    @endif
@endsection