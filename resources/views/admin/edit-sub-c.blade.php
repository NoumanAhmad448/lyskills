@extends('admin.admin_main')


@section('content')
    <h1> Edit SubCategory </h1> 
    <p> Edit and Save your SubCategory  </p>
    <div class="d-flex justify-content-end mb-1">
        <a href="{{route('admin_sub_categories')}}" class="btn btn-lg website-outline"> View SubCategory </a>
    </div>
    @include('session_msg')
    <form action="{{route('admin_update_sub_c',compact('c'))}}" method="post" class="mt-2">
        @csrf
        @method('patch')
        <div class="form-group">
            <label for="sub_c">Main Category</label>        
            <select class="custom-select  mb-1 @error('sub_c') is-invalid @enderror"  id="sub_c" name="sub_c">
                <option value=""> Choose Main Category </option>
                @foreach ($categories as $ca)                
                    <option value="{{$ca->value ?? null }}" @if( $c->categories_id == $ca->id) {{ __('selected') }} @endif  >  {{$ca->name ?? 'DB ERROR'}}</option>                    
                @endforeach                
            </select>
            @error('sub_c')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="name"> Category Name </label>
            <input type="text" class="form-control mb-2 @error('name') is-invalid @enderror" id="name" aria-describedby="category name" name="name" 
                    placeholder="Category Name"
                    value="{{ $ca->name ?? ''}}"
            >            
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-lg website-outline"> <i class="fa fa-floppy-o" aria-hidden="true"></i> Update SubCategory  </button>
    </form>
    
@endsection 


@section("page-js")
    <script>
        $(function(){
       
        setTimeout(() => {
            $('#name').removeClass('is-invalid');
            $('.alert').fadeOut();
        }, 10000);

        });
    </script>
@endsection 