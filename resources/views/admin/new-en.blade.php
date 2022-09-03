@extends('admin.admin_main')
@section('page-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section('content')
    <h1> 
        New Offline Enrollment Requests
    </h1>
    

     @include('session_msg')

     @if($of_ens->count())
        <div class="table-responsive my-5">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th scope="col">Mark</th>
                   
                    <th scope="col"> Name </th>
                    <th scope="col"> Email </th>
                    <th scope="col"> Course </th>
                    <th scope="col"> Date </th>                    
                    <th scope="col"> Link </th>                    
                    
                </tr>
                </thead>
                <tbody>
                @foreach ($of_ens as $post)
                    <tr>
                       @php $name = $post->user->name; $email = $post->user->email; $course_title = $post->course->course_title; 
                       $user = $post->user->id; $course = $post->course->id; @endphp
                        <td>
                            <form action="{{route('n_en_p',compact('user','course'))}}" method="post">
                                @csrf
                                <input type="checkbox" name="status" class="change_status" /> 
                            </form>
                        </td>
                        
                        <td> {{ $name }}</td>
                        <td> {{ $email }} </td>
                        
                        <td> {{ $course_title }}</td>
                        <td> 
                            {{$post->created_at}}
                        </td>
                       
                        <td> 
                            <a href="{{route('user-course', ['slug' => $post->course->slug]) }}"> Link </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
            <div class="jumbotron text-center bg-white mt-5">
                <img src="{{asset('img/not_found.png')}}" alt="no post found" width="100" height="100" class="img-fluid rounded-circle">
                <div > no new enrollment found </div>
            </div>
    @endif
     
@endsection


@section('page-js')
    <script>  
        $(function(){  
            $('#n_en').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');
            setTimeout(() => {
                $('.alert').fadeOut();
            }, 10000);

            $('.change_status').change(function(){
                if(confirm('Are you sure to change the status of your post?')){
                    $(this).parents('form').first().submit();
                }
            });            
        });
    </script>
@endsection