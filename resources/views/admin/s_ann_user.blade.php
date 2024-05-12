@extends('admin.admin_main')
@section('page-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    

    <x-instructor-notification >        
        <h1> 
            User Notification 
        </h1>
        <x-slot name="create_notification">
            <div class="d-flex justify-content-end">
                <a href="{{route('c_info_user')}}" class="btn btn-lg btn-info">
                    Create Notification 
                </a>
            </div>
        </x-slot>
        
        <x-slot name="instructors">
            @include('session_msg')
            @if(isset($users) && $users->count())
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Message</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Del</th>
                    </tr>
                    </thead>
                    <tbody>                
                    
                    @foreach ($users as $i)
                        <tr class="con">
                            <th scope="row"> {{ $i->id ?? '' }}</th>
                            <td> {{ $i->message ? reduceCharIfAv($i->message,70) : '' }} </td>
                            <td> <a href="{{route('show_edit_user',['i' => $i->id])}}" class="text-info"> Edit </a> </td>
                            <td> <div link="{{route('____delete_user',['i' => $i->id])}}" class="text-danger cursor_pointer del-not"> Delete </div>  </td>
                        </tr>  
                    @endforeach
                    
                    </tbody>
                </table>
            @endif
        </x-slot>
    </x-instructor-notification>


@endsection


@section('page-js')
    <script>
        $(function(){            
            $('#s_info_user').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');
            $('.del-not').click(function(){
                $('.show_message').fadeOut();
                if(confirm("Do you want to delete this notification?")){
                    let el = $(this);
                    let url = $(this).attr('link');
                    if(url){
                        $.ajax({
                            url: url,
                            type: 'post',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(){        
                                show_message('deleted');
                                el.parents('.con').first().remove();
                            }
                        })
                    }
                }
            });
        
        setTimeout(() => {
            $('.show_message').fadeOut();
        }, 10000);

        });
    </script>
@endsection


@section('page-js')
    @includeIf('admin.visible_bar');
@endsection