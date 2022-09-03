@extends('admin.admin_main')
@section('page-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
@endsection

@section('content')
    <h1> Emails</h1>
    <hr/>
    @include('session_msg')
    <form action="{{route('a-p-send-email')}}" method="POST">
        @csrf
        <div class="form-group">
          <label for="status">Choose Student/Instructors</label>
          <select class="custom-select @error('status') is-invalid @enderror" id="status" name="status">
            <option selected value=""> Choose Student/Instructors</option>
            <option value="s">Students</option>
            <option value="i">Instructors</option>            
          </select>
          @error('status')
                <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        </div>
        <div class="form-group">
          <label for="subject"> Subject </label>
          <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" placeholder="Subject"
          value="{{old('subject')}}">
          @error('subject')
                <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        </div>

        <div class="form-group">
          <label for="body"> Email Body</label>
          <textarea class="form-control @error('body') is-invalid @enderror" id="body" name="body" placeholder="body" rows="40">{{old('body')}}</textarea>
          @error('body')
                <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        </div>       
        <button type="submit" class="btn btn-website btn-lg">Send Email </button>
      </form>
@endsection

@section('page-js')
    <script>
        $(function(){
            $('input,textarea,select').click(function(){
                $('input,textarea,select').removeClass('is-invalid');
                $('.alert').fadeOut();
            });
        });
        $(function(){
            CKEDITOR.replace('body', {
            filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
      });
    </script>
@endsection