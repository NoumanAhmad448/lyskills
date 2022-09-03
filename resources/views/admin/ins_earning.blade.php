@php 
    use App\Models\User;
    use App\Models\Course;
@endphp
@extends('admin.admin_main')

@section('page-css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
@endsection
@section('content')
    <h1> Total Instructor Earning </h1>
    @if ($ins_earning && $ins_earning->count())
    <div class="table-responsive mt-5">
        <table class="table table-striped" id="earning">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Course Name</th>
                <th scope="col">Student</th>
                <th scope="col">Student Email</th>
                <th scope="col">Payment</th>
                <th scope="col">Date</th>
                <th scope="col">Payment Method</th>                    
              </tr>
            </thead>
            <tbody>
                @php $id = 1; @endphp
        @foreach ($ins_earning as $earning)        
            <tr>
                @php 
                    $student = User::where('id',$earning->user_id)->select('name','email')->first();
                    $course = Course::where('id',$earning->course_id)->select('course_title')                    ->first();
                @endphp
                <td> 
                    {{ $id }}                    
                </td>
                <td>
                    @if($course->count())
                    {{$course->course_title ?? ''}}
                    @else 
                    ''
                    @endif
                </td>
                <td> 
                    @if($student->count())
                    {{$student->name ?? ''}}
                    @else 
                    {{ '' }}
                    @endif
                </td>
                <td> 
                    @if($student->count())
                    {{$student->email ?? ''}}
                    @else 
                    {{ '' }}
                    @endif
                </td>
                <td>
                    ${{$earning->amount}}
                </td>
                <td>
                    {{$earning->created_at}}
                </td>
                <td>
                    {{$earning->pay_method}}
                </td>
            </tr>   
            @php $id +=1; @endphp                          
        @endforeach
            </tbody>
        </table>
        </div>

    @else
    <div class="jumbotron bg-white text-dark text-center">
        <h3> No History Found</h3>
        <div class="text-danger text-center font-bold"> No History found</div>
    </div>
    @endif



@endsection

@section('page-js')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

<script>
    $(document).ready( function () {
    $('#earning').DataTable();
} );
</script>
@endsection
