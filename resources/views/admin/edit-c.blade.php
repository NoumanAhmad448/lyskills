@extends('admin.admin_main')


@section('content')
    <h1> Edit Category </h1> 
    <p> Edit and Save your category  </p>
    <div class="d-flex justify-content-end mb-1">
        <a href="{{route('admin_main_categories')}}" class="btn website-btn btn-lg"> View Category </a>
    </div>
    @include('session_msg')
    <form action="{{route('admin_update_main_c',compact('c'))}}" method="post" class="mt-2">
        @csrf
        @method('patch')
        <div class="form-group">
            <label for="name"> Category Name </label>
            <input type="text" class="form-control mb-2 @error('name') is-invalid @enderror" id="name" aria-describedby="category name" name="name" 
                    placeholder="Category Name"
                    value="{{ $c->name ?? ''}}"
            >            
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn website-btn btn-lg"> <i class="fa fa-floppy-o" aria-hidden="true"></i> Update Category  </button>
    </form>
    
@endsection 


@section("page-js")
    <script>
        setTimeout(() => {
            $('#name').removeClass('is-invalid');
            $('.alert').fadeOut();
        }, 10000);
    </script>
@endsection 