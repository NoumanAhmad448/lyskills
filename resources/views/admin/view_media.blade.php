@extends('admin.admin_main')
@section('page-css')
    <link href="https://vjs.zencdn.net/7.10.2/video-js.css" rel="stylesheet" />
@endsection

@section('content')
    <h1> All Media </h1>
    @if($media->count())
    
    <div class="container">
        <div class="row">           
        
        @foreach ($media as $m)
            @php $path = asset('storage/'.$m->lec_name);            
            @endphp
                
            <div class="col-md-4">
                <video class="w-100" controls>
                    <source src="{!!$path!!}" type="{!!$m->f_mimetype!!}">            
                    Your browser does not support the video tag.
                </video>
            </div>
         
        @endforeach
        @else
         <div class="jumbotron text-center">
             <h3> No Data Found  </h3>
             <p> No one has uploaded any video yet </p>
         </div>
    @endif
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <div> {{ $media->links() }} </div>
    </div>
@endsection



@section('page-js')
    <script>
        $(function(){
            $('#a_media').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');               
        });
    </script>
        <script src="https://vjs.zencdn.net/7.10.2/video.min.js"></script>
@endsection