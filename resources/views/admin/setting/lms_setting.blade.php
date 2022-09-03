@extends('admin.admin_main')
@section('page-css')
   <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <h1> LMS Setting </h1> 
    <p> This Page is displaying the LMS setting of the website </p>
    <hr/>

    @include('session_msg')
    <form action="{{route('admin_p_lms_setting')}}" method="POST">
        @csrf        
        <div class="row">
            <div class="col-md-4">
                <label > Discussion </label>
            </div>
            
            <div class="col-md-6">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="discussion" name="discussion" @if(isset($s) && $s->isDisscussion) {{ __('checked')}} @endif >
                    <label class="custom-control-label" for="discussion"> Enable/Disable </label>
                  </div>
                
                <small class="form-text text-muted"> By enabling discussion, students can ask questions to instructors directory from every lecture page, they will get a form to ask question under every lecture </small>
                <button type="submit" class=" mt-2 btn btn-primary"> <i class="fa fa-floppy-o" aria-hidden="true"></i>
                    Update 
                </button>
            </div>
        </div>
        
        
      </form>
@endsection 


@section("page-js")
    <script>
        $(function(){
            $('#a_lms_setting').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');
            $('.s_sub_menu').removeClass('d-none');
            setTimeout(() => {
                $('.alert').fadeOut();
            }, 5000);
        });
    </script>
@endsection 