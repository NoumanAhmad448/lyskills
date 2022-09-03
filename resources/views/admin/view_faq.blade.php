@extends('admin.admin_main')
@section('page-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section('content')
    <h1> 
        FAQ
    </h1>
    <div class="d-flex justify-content-end">
        <a href="{{route('admin_c_faq')}}" class="btn btn-lg btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
            Create FAQ
        </a>
    </div>

     @include('session_msg')

     @if($faqs->count())
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
                @foreach ($faqs as $faq)
                    <tr>
                        @php $status = $faq->status; @endphp
                        <td>
                            <form action="{{route('admin_cs_faq',compact('faq'))}}" method="post">
                                @csrf
                                <input type="checkbox" name="status" class="change_status" @if($status === "published") checked @endif/> 
                            </form>
                        </td>
                        
                        <td> {{ $faq->name }}</td>
                        <td> {{ $faq->email }} </td>
                        <td >
                            <div class="badge @if($status == "unpublished") badge-danger @else badge-success @endif  rounded">
                                 {{ $status }}
                            </div>
                        </td>
                        <td> {{ $faq->title }}</td>
                        <td> 
                            <div class="text-success" > 
                             <a href="{{route('admin_edit_faq', compact('faq'))}}">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                            </div>
                        </td>
                        <td> 
                            <form action="{{route('admin_faq_delete',compact('faq'))}}" method="POST">
                                @csrf
                                @method('delete')
                                <div class="text-danger delete_faq cursor_pointer"> <i class="fa fa-trash" aria-hidden="true"></i>  </div>
                            </form>
                        </div>    
                        </td>

                        <td>
                            <a href="{{route('public_faqs', ['slug' => $faq->slug])}}" target="_blank"> Link </a>
                        </td>
                        
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between">
            <div> @if($faqs) Total {{$faqs->count()}} @endif </div>
            <div> {{ $faqs->links() }} </div>
        </div>
        

        @else
            <div class="jumbotron text-center bg-white mt-5">
                <img src="{{asset('img/not_found.png')}}" alt="no faq found" width="100" height="100" class="img-fluid rounded-circle">
                <div > You have not created any faq yet. Please create new faq by clicking the button create faq </div>
            </div>
        @endif
     
@endsection


@section('page-js')
    <script>  
        $(function(){  
            $('#a_faq').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');
            setTimeout(() => {
                $('.alert').fadeOut();
            }, 10000);

            $('.change_status').change(function(){
                if(confirm('Are you sure to change the status of your faq?')){
                    $(this).parents('form').first().submit();
                }
            });

            $('.delete_faq').click(function(e){
                if(confirm("Do you want to delete this faq?")){
                    e.preventDefault();
                    $(this).parents('form').first().submit();
                }
            });
        });
    </script>
@endsection