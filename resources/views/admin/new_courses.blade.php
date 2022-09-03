@extends('admin.admin_main')
@section('page-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <h1>
        New Courses 
    </h1>  
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <select class="custom-select mb-1 mb-md-0" id="status" name="status">
                        <option value=""> Choose Status </option>
                        <option value="p" > Published</option>                                            
                    </select>
                </div>
                <div class="form-group">
                    <input type="hidden" value="" id="courses_nos" />
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-info my-1 my-md-0" id="update"> <i class="fa fa-floppy-o" aria-hidden="true"></i> Update </button>
            </div>
        </div>
    </div>
    @if ($courses->count())
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col"> Mark </th>
                <th scope="col"> Title </th>
                <th scope="col"> Categories </th>
                <th scope="col"> Instructor </th>
                <th scope="col"> Email </th>
                <th scope="col"> Status </th>
                <th scope="col"> Date </th>                
                <th scope="col"> Link </th>                
            </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)                
                <tr>
                    <td>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input course_no" name="course_no"  values="{{$course->id}}" />
                        </div>
                    </td>
                    <td> {{ $course->course_title ?? '' }}</td>
                    <td> {{ $course->categories_selection ?? '' }}</td>
                    <td> {{ $course->user->name ?? '' }} </td>
                    <td> {{ $course->user->email ?? '' }} </td>                    
                    @php $s = $course->status; @endphp
                    <td> @if($s) 
                        <div class="badge @if($s == "block") {{ __('badge-danger') }} 
                        @elseif($s == "pending") {{ __('badge-warning')}} @else {{__('badge-info')}} @endif" > {{ $s ?? '' }} </div> @endif 
                    </td>    
                    <td> {{ $course->updated_at }} </td>
                    <td> <a href="{{route('user-course', ['slug' => $course->slug])}}"> Link </a> </td>
                </tr>
            @endforeach
            
            </tbody>
        </table>
    </div>
    <div class="text-md-right text-center mb-5 mb-md-0">
        {{ $courses->links() }}
    </div>
    @else
        <div class="jumbotron bg-light text-center">
            <img src="{{asset('img/not_found.png')}}" alt="Lyskills" class="img-fluid img-thumbnail rounded-pill" width="100"/>
            <div> No new course </div>
        </div>
    @endif

@endsection

@section('page-js')
    <script>
        $('#i_new_courses').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');
            $('#update').click(function(){
                let status = $('#status').val();                
                if(status !== ""){
                    course_no = $('#courses_nos').val();
                    if(course_no !== ""){
                        $.ajax({                            
                            type: 'post',
                            url: '{{route("change_course_status")}}',
                            dataType: 'json',
                            data: {'course_no': course_no, 'status': status ,'_token': '{{csrf_token()}}'}
                            ,success: d => {
                                  alert(d);
                                  location.reload();
                            },error: d => {
                                errors = JSON.parse(d.responseText)['errors'];
                                console.log(errors);
                            }
                        });
                    }else{
                        alert("Please select a course");
                    }
                }else{
                    alert('Please choose the status');
                }
            });

            $('.course_no').change(function(){
                let current_el = $(this);                    
                if(current_el.is(':checked')){
                    $('#courses_nos').val(current_el.attr('values'));
                }
            });
    </script>
@endsection
