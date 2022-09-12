@php
    use App\Models\CourseEnrollment;
@endphp
@extends('admin.admin_main')


@section('page-css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
@endsection
@section('content')
<table class="table table-striped" id="enrollement">
    <thead>
        <tr>
            <th scope="col">Student Name</th>
            <th scope="col">Email</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @if(!empty($students))
            @foreach ($students as $student)
                <tr>
                    <form method='post' action='{{route("xueshiXueshengPost")}}'>
                        @csrf
                        <input type='hidden' name='student_id' value='{{$student->id}}'>
                        <input type='hidden' name='course_id' value='{{$course}}'>
                        <input type='hidden' name='action'
                            value="{{ CourseEnrollment::where('course_id', $course)->where('user_id',$student->id)->first() ? 'unenroll': 'enroll'}}">
                        <td> {{ $student->name }} </td>
                        <td> {{ $student->email }}</td>
                        <td>
                            <button type='submit' class="btn btn-sm btn-info">
                                {{ CourseEnrollment::where('course_id', $course)->where('user_id',$student->id)->first() ? "Unenroll": "Enroll"}}
                            </button>
                        </td>
                    </form>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
@endsection