@extends('admin.admin_main')


@section('content')
    <h1> Categories </h1> 
    <p> Create,edit, update, and delete your category </p>

    @include('session_msg')
   <div class="d-flex justify-content-end">
       <a href="{{route('admin_create_main_c')}}" class="btn btn-lg website-outline"> <i class="fa fa-hand-o-up" aria-hidden="true"></i>
        Create Category </a>
   </div>

   @if($categories->count())
   <div class="table-responsive mt-3">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Category</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($categories as $c)
                    <tr>
                        <th scope="row"> {{ $c->id ?? '' }} </th>
                        <td> {{ $c->name ?? '' }} </td>
                        <td> 
                            <a href="{{route('admin_edit_main_c', compact('c'))}}" class="text-info"> 
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>
                        </td>
                        <td> 
                            <form action="{{route('admin_delete_main_c',['category' => $c])}}" method="post" >
                                    @csrf 
                                    @method('delete')
                                <div class="btn text-danger cursor-pointer del"> <i class="fa fa-trash" aria-hidden="true"></i>
                                </div>
                            </form>
                        </td>
                    </tr>                
                @endforeach
            
            </tbody>
        </table>
    </div>
   @endif

@endsection 






@section("page-js")
    <script>
        $(function(){
            $('.del').click(function(){
                if(confirm('Are you sure to delete this category? Deleting this category will delete all its sub categories as well')){
                    $(this).parents('form').first().submit();
                }
            });
        });
    </script>
@endsection 