@extends('admin.admin_main')


@section('content')

    <h1> Change Price </h1>
    <hr/>
    @include('session_msg')
    <form action="{{route('admin_change_price_post',compact('course'))}}" method="post">
        @csrf
        @method('patch')
        <div class="form-group">
            <label for="pass"> Change Price </label>
            <div class="input-group mb-3">
                <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price"
                     placeholder="Price" value="@if(isset($course) && isset($course->price)) {{ $course->price->pricing ?? '' }} @endif">                                        
             </div>
            @error('price')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror 
        </div>
        <button type="submit" class="btn btn-info"> <i class="fa fa-floppy-o" aria-hidden="true"></i> Update Price </button>
    </form>
@endsection



@section('page-js')
    <script>
        $(function(){
            setTimeout( ()=>{
                $('input').removeClass('is-invalid');
                $('.alert').fadeOut();
            },15000);

            $('input').click(()=>{
                $('input').removeClass('is-invalid');
                $('.alert').fadeOut();
            });
        });
    </script>
@endsection