@extends('courses.dashboard_main')
@section('page-css')
<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@section('content')
<div class="border bg-white col-md-9 mt-3 p-3">

    <section class="setting">
        <h1> Setting</h1>
        <hr>
        @include('session_msg')
        <div class="row">
            <div class="col-4">
                <form action="{{route('post_setting',compact('course'))}}" method="post">
                    @csrf
                    <button class="btn btn-lg btn-outline-info" type="submit" @if($course->status === "draft" || $course->status === "unpublished")
                            {{ __('disabled') }}
                            @endif >
                            Unpublish Course
                    </button>
                </form>
            </div>
            <div class="col-8">
                You are free to make your course unpublish and it will not apear in the search result of 
                new user.
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-4">
                    <button link="{{route('course_delete',[ 'course_id' => $course])}}" 
                        class="btn btn-lg btn-outline-danger del-course" type="button" 
                             >
                            Delete Course
                    </button>
                
            </div>
            <div class="col-8">
                If you delete your course, it will be removed from your side but those students 
                who are enrolled in your course will still be able to see it. However, for new users
                course will not be displayed to them. 
            </div>
        </div>
        <hr/>
    </section>
</div>
@endsection

@section('page-js')

<script>
    $(function(){
        setTimeout(() => {
            $('.alert').fadeOut();
        }, 10000);



        $('.del-course').click(() => {

            let url = $('.del-course').attr('link');
            if(url){
                $('#del-modal').find('.delete-form-action').attr('action',url) ;
                $('#del-modal').modal('show');
            }    
        });


    });
</script>

<div class="modal" tabindex="-1" id="del-modal"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header text-white bg-danger">
          <h5 class="modal-title">Course Delete</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p> You are about to delete this course. If we find any user enrolled in your course, your course will not be able to 
              delete on our website but will not be shown to you. However, new user will not be able to see it in the search result. 
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
          <form action="" method="post" class="delete-form-action">
              @csrf
              @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete Course</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection