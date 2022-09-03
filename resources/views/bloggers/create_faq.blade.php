@extends('bloggers.blogger_main')
@section('page-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

@endsection


@section('content')
    <h1> Create FAQ </h1>
    <div class="d-flex justify-content-end">
        <a href="{{route('blogger_v_faq')}}" class="btn btn-lg btn-info"> View FAQs </a>
    </div>

    <form method="POST" action="{{route('blogger_s_faq')}}" enctype="multipart/form-data"    >
        @csrf
        <div class="form-group">
          <label for="title"> Title </label>
          <input type="text" class="form-control mb-1 @error('title') is-invalid @enderror" id="title" name="title" placeholder="Title" 
                value="{{ old('title') }}">
          @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        </div>
        <div class="form-group">
          <label for="message">Message</label>
          <textarea type="password" class="form-control mb-2" rows="15" id="message" name="message"
           placeholder="Message" >{{ old('message') }}</textarea>
          @error('message')
              <div class="alert alert-danger">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-group">
            <img src="#" alt="Post Image" class="img-fluid d-none img" width="150" />
        </div>
        <div class="form-group">
            <input type="file" class="d-none" id="upload_img" name="upload_img" onchange="readURL(this)">
            <label class="btn btn-info" for="upload_img"> <i class="fa fa-upload" aria-hidden="true"></i> Upload Image </label>
            @error('upload_img')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>        

        <button type="submit" class="btn btn-lg btn-info"> 
            <i class="fa fa-floppy-o" aria-hidden="true"></i> Save FAQ
        </button>
      </form>

@endsection


@section('page-js')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    {{-- <script src="https://cdn.tiny.cloud/1/8u3ztd4lh4p738dj3wqjofivswytdrssy8lgrqzc5jb4vcce/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> --}}
    <script>
        $(function(){        
        //     tinymce.init({
        //         selector: 'textarea#message',
        //         menubar: false,
        //         plugins: 'lists, link, image, media',
        //         toolbar: 'h1 h2 bold italic strikethrough blockquote bullist numlist backcolor | link image media | removeformat help',
        //    });

        //    $('#title, #message, #upload_img').click(function(){
        //         $('.alert').text('').addClass('d-none');
        //         $(this).removeClass('is-invalid');
        //    });
        });
    </script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.img')
                        .attr('src', reader.result).removeClass('d-none');                        
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <script type="text/javascript">
        CKEDITOR.replace('message', {
            filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });

         // hide message 
         $('textarea,input').click(vanish);

function vanish(){
    $('input,textarea').removeClass('is-invalid');
    $('.alert').fadeOut();
}
});
    </script>
@endsection