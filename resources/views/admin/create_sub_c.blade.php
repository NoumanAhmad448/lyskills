@extends('admin.admin_main')


@section('content')
    <h1> Create Sub Category </h1> 
    <p> Create your sub category  </p>
    <div class="d-flex justify-content-end">
        <a href="{{route('admin_sub_categories')}}" class="btn website-outline btn-lg"> View SubCategories </a>
    </div>
    <form action="{{route('admin_store_sub_c')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="sub_c">Main Category</label>        
            <select class="custom-select  mb-1 @error('sub_c') is-invalid @enderror"  id="sub_c" name="sub_c">
                <option value="" selected> Choose Main Category </option>
                @foreach ($categories as $c)
                    <option value="{{$c->value ?? null }}"> {{$c->name ?? 'DB ERROR'}}</option>                    
                @endforeach                
            </select>
            @error('sub_c')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="name"> SubCategory Name </label>
            <input type="text" class="form-control mb-2 @error('name') is-invalid @enderror" id="name" aria-describedby="category name" name="name" 
                    placeholder="Category Name"
                    value="{{ old('name')}}"
            >            
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn website-outline btn-lg"> <i class="fa fa-floppy-o" aria-hidden="true"></i> Save </button>
    </form>
    
@endsection 


@section("page-js")
    <script>
        $(function(){
        
        function reset(){
            $('#name , #sub_c').removeClass('is-invalid');
            $('.alert').fadeOut();
        }

        setTimeout(() => {
            reset();
        }, 10000);

        $('#name, #sub_c').click(function(){
            reset();
        });

    });
    </script>
@endsection 