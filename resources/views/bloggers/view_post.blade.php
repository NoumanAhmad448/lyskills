@extends('bloggers.blogger_main')
@section('page-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/text.css')}}">
@endsection


@section('content')
    <h1> 
        Posts
    </h1>
    <div class="d-flex justify-content-end">
        <a href="{{route('blogger_c_p')}}" class="btn btn-lg btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
            Create Post
        </a>
    </div>

     @include('session_msg')

     @if($posts->count())
        <div class="table-responsive mt-2">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th scope="col">Mark</th>
                   
                    <th scope="col"> Name </th>
                    <th scope="col"> Email </th>
                    <th scope="col"> Status </th>
                    <th scope="col"> Title </th>
                    <th scope="col"> Edit </th>
                    <th scope="col"> Delete </th>
                    <th scope="col"> link </th>
                    
                </tr>
                </thead>
                <tbody>
                @foreach ($posts as $post)
                    <tr>
                        @php $status = $post->status; @endphp
                        <td>
                            <form action="{{route('blogger_cs_p',compact('post'))}}" method="post">
                                @csrf
                                <input type="checkbox" name="status" class="change_status" @if($status === "published") checked @endif/> 
                            </form>
                        </td>
                        
                        <td> {{ $post->name }}</td>
                        <td> {{ $post->email }} </td>
                        <td >
                            <div class="badge @if($status == "unpublished") badge-danger @else badge-success @endif  rounded">
                                 {{ $status }}
                            </div>
                        </td>
                        <td> {{ $post->title }}</td>
                        <td> 
                            <div class="text-success" > 
                             <a href="{{route('blogger_edit_p', compact('post'))}}">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                            </div>
                        </td>
                        <td> 
                            <form action="{{route('blogger_p_delete',compact('post'))}}" method="post">
                                @csrf
                                @method('delete')
                                <div class="text-danger delete_post cursor_pointer"> <i class="fa fa-trash" aria-hidden="true"></i>  </div>
                            </form>
                        </div>    
                        </td>

                        <td>
                            <a href="{{route('public_posts', ['slug' => $post->slug])}}" target="_blank"> Link </a>
                        </td>
                        
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between">
            <div> @if($posts) Total {{$posts->count()}} @endif </div>
            <div> {{ $posts->links() }} </div>
        </div>
        

        @else
            <div class="jumbotron text-center bg-white mt-5">
                <img src="{{asset('img/not_found.png')}}" alt="no post found" width="100" height="100" class="img-fluid rounded-circle">
                <div > You have not created any post yet. Please create new post by clicking the button create post </div>
            </div>
        @endif
     
@endsection


@section('page-js')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script>  
        $(function(){  
            $('#a_post').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');
            setTimeout(() => {
                $('.alert').fadeOut();
            }, 10000);

            $('.change_status').change(function(){
                if(confirm('Are you sure to change the status of your post?')){
                    $(this).parents('form').first().submit();
                }
            });

            $('.delete_post').click(function(e){
                if(confirm("Do you want to delete this post?")){
                    e.preventDefault();
                    $(this).parents('form').first().submit();
                }
            });
        });
    </script>
@endsection