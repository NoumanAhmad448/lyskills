@extends('admin.admin_main')
@section('page-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

@endsection


@section('content')
    <h1> Edit Post </h1>
    <div class="d-flex justify-content-end">
        <a href="{{route('admin_v_p')}}" class="btn btn-lg btn-info"> View Posts </a>
    </div>

    @include('session_msg')

    <form method="POST" action="{{route('admin_update_p',compact('post'))}}" enctype="multipart/form-data"  >
        @csrf
        @method('put')
        <div class="form-group">
          <label for="title"> Title </label>
          <input type="text" class="form-control mb-1 @error('title') is-invalid @enderror" id="title" name="title" placeholder="Title" 
                value="{{ $post->title  ?? '' }}">
          @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        </div>
        <div class="form-group">
          <label for="message">Message</label>
          <textarea class="form-control mb-2" rows="15" id="message" name="message"
           placeholder="Message" >{{ $post->message ?? '' }}</textarea>
          @error('message')
              <div class="alert alert-danger">{{ $message }}</div>
          @enderror
        </div>
        <img src="{{ config('setting.s3Url').$post->upload_img }}" alt="lyskills" width="100" height="50" class="img-fluid mb-1"/>
        <div class="form-group">
            <input type="file" class="d-none" id="upload_img" name="upload_img">
            <label class="btn btn-info" for="upload_img"> <i class="fa fa-upload" aria-hidden="true"></i> Upload Image </label>
            @error('upload_img')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-lg btn-info"> 
            <i class="fa fa-floppy-o" aria-hidden="true"></i> Update Post 
        </button>
      </form>

@endsection


@section('page-js')
    {{-- <script src="https://cdn.tiny.cloud/1/8u3ztd4lh4p738dj3wqjofivswytdrssy8lgrqzc5jb4vcce/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> --}}
    <script>
        $(function(){        
        //     tinymce.init({
        //         selector: 'textarea#message',
        //         menubar: false,
        //         plugins: 'lists, link, image, media',
        //         toolbar: 'h1 h2 bold italic strikethrough blockquote bullist numlist backcolor | link image media | removeformat help',
        //    });

           setTimeout(() => {
                $('.alert').fadeOut();
                $('#title,#message').removeClass('is-invalid');
           }, 5000);
           
        });
    </script>
     <script type="text/javascript">
        CKEDITOR.replace('message', {
            filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endsection