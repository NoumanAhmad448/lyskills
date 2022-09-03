@extends('layouts.guest')
@section('page-css')
<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection
@section('content')
    <section style="min-height: 100vh">
        <div class="container" >
            <div class="row">
                <div class="col-md-8">
                    <h1 class="text-uppercase">{{$course->course_title}} Comments</h1>               
    
                </div>
                
            </div>
        </div>
        <div class="container" >
            <div class="row">
                <div class="offset-md-2 col-md-10">
                    <form action="{{route('laoshi-commentPost')}}" method="POST" class="mt-5">
                        @csrf
                        @include('session_msg')
                        <div class="form-group">
                          <label for="message">Type Comment</label>
                          <textarea class="form-control" name="message" id="message" rows="10"
                           placeholder="start writing...."></textarea>
                           @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul id="errors">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif                      
                        </div>   
                        <input type="hidden" name="course_slug" value="{{$course->id}}">                 
                        <button type="submit" class="btn btn-website">Send</button>
                    </form>


                    @if ($comments->count())
                        @foreach ($comments as $comment)
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="my-3">
                                            {{ $comment->comment }}
                                        </div>
                                    </div>
                                    <div class="col-1 cursor_pointer"> 
                                        <div class="comment_edit" message="{{$comment->comment}}"
                                            comment_id = "{{$comment->id}}"
                                            ><i class="fa fa-pencil text-success" aria-hidden="true"></i>
                                                                                </div>
                                    </div>
                                    <div class="col-1 cursor_pointer text-danger" >
                                        <div onClick="deleteComment({{$comment->id}})"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                
            </div>
        </div>
    </section>

    @section('script')
        <script>
            $('#message').click(function(){
                $('li').remove();
            });

            function deleteComment(msg){
                // console.log('working');
                if(confirm("Are you sure to delete this comment")){
                    let message_id = msg;
                    // console.error(message_id);
                    $.ajax({
                        url: "{{route('laoshi-commentDelete')}}",
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {message_id: message_id },
                        success: function(){
                            location.reload();
                        }

                    });
                }
            }

            $(".comment_edit").click(function(){
                let msg = $(this).attr('message'); 
                let comment_id = $(this).attr('comment_id');
                console.error(msg);
                console.error(comment_id);
                $("#new_msg").text(msg);
                $("#comm_id").val(comment_id);
                $("#me_modal").modal('show');                
            });
        </script>
    @endsection

    <div class="modal" tabindex="-1" role="dialog" id="me_modal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Update Comment</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="{{route('laoshi-commentUpdate')}}" method="POST" class="mt-5">
                    @csrf
                    @method('patch')                    
                    <div class="form-group">
                      <label for="message">Type Comment</label>
                      <textarea class="form-control" name="new_msg" id="new_msg" rows="10"
                       placeholder="start writing...."></textarea>                                          
                    </div>   
                    <input type="hidden" id="comm_id" name="comm_id" value="">                 
                    <button type="submit" class="btn btn-website">update</button>
                </form>
            </div>            
          </div>
        </div>
      </div>

@endsection