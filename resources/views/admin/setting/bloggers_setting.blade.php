@extends('admin.admin_main')
@section('page-css')
   <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <h1> Blogger Setting </h1> 
    {{-- <p> This Page is displaying the LMS setting of the website </p> --}}
    <hr/>

    @include('session_msg')
    <form action="{{route('blogger-setting-post')}}" method="POST">
        @csrf        
        <div class="row">
            <div class="col-md-4">
                <label > Blogs </label>
            </div>
            
            <div class="col-md-6">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="blog_e_d" name="blog_e_d" @if(isset($s) && $s->isBlog) {{ __('checked')}} @endif >
                    <label class="custom-control-label" for="blog_e_d"> Enable/Disable </label>
                  </div>
                
                <small class="form-text text-muted"> By enabling it, bloggers will be able to perform blog posts </small>               
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-4">
                <label > FAQ </label>
            </div>
            
            <div class="col-md-6">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="faq" name="faq" @if(isset($s) && $s->isFaq) {{ __('checked')}} @endif >
                    <label class="custom-control-label" for="faq"> Enable/Disable </label>
                  </div>
                
                <small class="form-text text-muted"> By enabling it, bloggers will be able to perform faq posts </small>
                <button type="submit" class=" mt-5 btn btn-primary"> <i class="fa fa-floppy-o" aria-hidden="true"></i>
                    Update 
                </button>
            </div>
        </div>
        
        
      </form>
@endsection 


@section("page-js")
    <script>
        $(function(){
            $('#blogger-setting').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');
            $('.s_sub_menu').removeClass('d-none');
            setTimeout(() => {
                $('.alert').fadeOut();
            }, 5000);
        });
    </script>
@endsection 