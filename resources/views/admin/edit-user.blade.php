@extends('admin.admin_main')
@section('content')
    <h1> {{ strtoupper($user->name ??  'Student') }} </h1>
    @if (session('status'))
        <div class="alert alert-success text-center">
            {{ session('status') }}
        </div>
    @endif
    <form action="{{route('a_u_users',compact('user'))}}" method="post">
        @method('PUT')
        @csrf
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="name" value="{{$user->name ?? '' }}">
         
        </div>
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="form-group">
          <label for="email">Email</label>
          <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{$user->email ?? '' }}" placeholder="Email">
        </div>
        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="student" name="student"  {{$user->is_student ? 'checked' : ''}}>
            <label class="custom-control-label" for="student"> Student </label>
        </div>
        <div class="custom-control custom-switch mt-1">
            <input type="checkbox" class="custom-control-input" id="instructor" name="instructor" {{$user->is_instructor ? 'checked' : ''}}>
            <label class="custom-control-label" for="instructor"> Instructor </label>
        </div>

        <button type="submit" class="btn btn-info mt-3"> Update </button>
      </form>
@endsection

@section('page-js')
    <script src="{{asset('js/edit_user.js')}}">       

    </script>
@endsection