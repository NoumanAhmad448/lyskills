@extends('admin.admin_main')
@section('page-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">-->
    <style>
        #history_filter input{
            border-radius: 10px;
        }
    </style>
@endsection


@section('content')
    <h1> Published Courses </h1>
    @if($courses && $courses->count())
        <div class="table-responsive mt-5">
            <table id="e">
                <thead >
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">course name</th>
                      <th scope="col">link</th>
                      <th scope="col">instructors</th>
                      <th scope="col">email</th>
                      <th scope="col">detail</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($courses as $course)
                        <tr>
                            <th scope="row"> {{ $course->id }} </th>
                            <td> {{ $course->course_title ?? '' }}</td>
                            <td> <a href="{{ route('user-course', ['slug' => $course->slug ] ) }}" target="_blank"> Link </a> </td>
                            <td> {{ $course->user->name ?? '' }}</td>
                            <td> {{ $course->user->email ?? '' }}</td>
                            <td> <a href="{{ route('enrollment-user', ['course' => $course->id])}}"> enrollments </a> </td>
                        </tr>                          
                      @endforeach
                  </tbody>
            </table>
        </div>
    @else 
        <div class="text-center">
            <h3 class="text-danger">
                No Course Published
            </h3>
            <div>
                We could not find any publish course. Once course is published come visit here 
            </div>
        </div>
        @endif
@endsection 

@section('page-js')

<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"/>

<script>
  
       
 $('#e').DataTable({
                    language: {
                searchPlaceholder: "Search records"
            },"pageLength": 25,
            order:[[0,"desc"]]
         });    

    
</script>
<script>
    $('#enrollment').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');
</script>
@endsection

