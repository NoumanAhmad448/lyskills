@extends('admin.admin_main')
@section('page-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        #history_filter input{
            border-radius: 10px;
        }
    </style>
@endsection

@section('content')
    <h1> Total number of Enrollments   </h1> <span class="badge badge-success"> Total Enrollment {{ $total_enrollment ?? ''}} </span>
    @if(config("setting.admin_guest_search_bar"))
        <div class="col-md-5 my-3" style="min-width: 100%">
            <div class="searchbar mt-4 mt-md-0">
                <input class="search_input" type="text" name="user_search" id="user_search"
                    placeholder="{{__('messages.enroll_stu')}}">
                <div class="search_icon btn"><i class="fa fa-search"
                        aria-hidden="true"></i>
                </div>
            </div>
        </div>
    @endif
    @if($users && $users->count())
        <div class="table-responsive mt-5">
            <table class="table" id="p">
                <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">email</th>
                      <th scope="col">name</th>
                      @if(config("setting.enable_course_unenroll"))
                        <th scope="col">{{__('messages.unenrolled')}}</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($users as $course)
                        <tr id="user_{{$course->user->id}}">
                            <td> {{ $course->user->id ?? '' }}</td>
                            <td> {{ $course->user->name ?? '' }}</td>
                            <td> {{ $course->user->email ?? '' }}</td>
                            @if(config("setting.enable_course_unenroll"))
                                <td><div class="btn btn-info"
                                onclick="unenroll_user( @if($course->user->id && $course->id) {!! $course->user->id !!},{!! $course_id !!} @endif)"> Unenroll  </div></td>
                            @endif
                        </tr>
                      @endforeach
            </table>
        </div>
    @else 
        <div class="text-center">
            <h3 class="text-danger">
                {{ __('messages.nceif')}}
            </h3>
            <div>
                {{ __("messages.tinue")}}
            </div>
        </div>
        @endif
@endsection 

@section('page-js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
        crossorigin="anonymous"></script>
    
    @include("admin.js-course-enrollment-page")
@endsection


