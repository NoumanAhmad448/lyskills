@extends('admin.admin_main')
@section('page-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section('content')
    <h1> 
        Pages
    </h1>
    <div class="d-flex justify-content-end">
        <a href="{{route('admin_c_page')}}" class="btn btn-lg btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
            Create Page
        </a>
    </div>

     @include('session_msg')

     @if($pages->count())
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
                @foreach ($pages as $page)
                    <tr>
                        @php $status = $page->status; @endphp
                        <td>
                            <form action="{{route('admin_cs_page',compact('page'))}}" method="post">
                                @csrf
                                <input type="checkbox" name="status" class="change_status" @if($status === "published") checked @endif/> 
                            </form>
                        </td>
                        
                        <td> {{ $page->name }}</td>
                        <td> {{ $page->email }} </td>
                        <td >
                            <div class="badge @if($status == "unpublished") badge-danger @else badge-success @endif  rounded">
                                 {{ $status }}
                            </div>
                        </td>
                        <td> {{ $page->title }}</td>
                        <td> 
                            <div class="text-success" > 
                             <a href="{{route('admin_edit_page', compact('page'))}}">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                            </div>
                        </td>
                        <td> 
                            <form action="{{route('admin_page_delete',compact('page'))}}" method="post">
                                @csrf
                                @method('delete')
                                <div class="text-danger delete_page cursor_pointer"> <i class="fa fa-trash" aria-hidden="true"></i>  </div>
                            </form>
                        </div>    
                        </td>

                        <td>
                            <a href="{{route('public_pages', ['slug' => $page->slug])}}" target="_blank"> Link </a>
                        </td>
                        
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between">
            <div> @if($pages) Total {{$pages->count()}} @endif </div>
            <div> {{ $pages->links() }} </div>
        </div>
        

        @else
            <div class="jumbotron text-center bg-white mt-5">
                <img src="{{asset('img/not_found.png')}}" alt="no page found" width="100" height="100" class="img-fluid rounded-circle">
                <div > You have not created any page yet. Please create new page by clicking the button create page </div>
            </div>
        @endif
     
@endsection


@section('page-js')
    <script>  
        $(function(){  
            $('#a_page').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');
            setTimeout(() => {
                $('.alert').fadeOut();
            }, 10000);

            $('.change_status').change(function(){
                if(confirm('Are you sure to change the status of your page?')){
                    $(this).parents('form').first().submit();
                }
            });

            $('.delete_page').click(function(e){
                if(confirm("Do you want to delete this page?")){
                    e.preventDefault();
                    $(this).parents('form').first().submit();
                }
            });
        });
    </script>
@endsection