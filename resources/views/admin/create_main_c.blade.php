@extends('admin.admin_main')


@section('content')
    <h1> Create Category </h1> 
    <p> Create your category  </p>
    <div class="d-flex justify-content-end">
        <a href="{{route('admin_main_categories')}}" class="btn btn-lg website-outline"> View Category </a>
    </div>
    <form action="{{route('admin_store_main_c')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="name"> Category Name </label>
            <input type="text" class="form-control mb-2 @error('name') is-invalid @enderror" id="name" aria-describedby="category name" name="name" 
                    placeholder="Category Name"
                    value="{{ old('title')}}"
            >            
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-lg website-outline"> <i class="fa fa-floppy-o" aria-hidden="true"></i> Save </button>
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