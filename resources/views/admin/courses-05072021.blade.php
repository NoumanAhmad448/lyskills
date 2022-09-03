@extends('admin.admin_main')
@section('page-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <h1>
        Courses 
    </h1>  
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <select class="custom-select mb-1 mb-md-0" id="status" name="status">
                        <option value=""> Choose Status </option>
                        <option value="p" > Published</option>
                        <option value="b" >  Block </option>
                        <option value="pe" > Pending </option>                        
                        <option value="mp" > Mark as Popular </option>                        
                        <option value="rp" > Remove From Popular </option>                        
                        <option value="mf" > Mark as Featured </option>                        
                        <option value="rf" > Remove From Featured </option>                        
                    </select>
                </div>
                <div class="form-group">
                    <input type="hidden" value="" id="courses_nos" />
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-info my-1 my-md-0" id="update"> <i class="fa fa-floppy-o" aria-hidden="true"></i> Update </button>
            </div>    
            <div class="col-md-6">
                <div class="row justify-content-end">
                    <div class="col-md-6">
                        <a href="{{route('s_p_c')}}" class="btn btn-info my-1 my-md-0">Show Popular Courses</a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('s_f_c')}}" class="btn btn-info my-1 my-md-0">Show Featured Courses</a>
                    </div>
                </div>                
            </div>        
            <div class="col-md-6">         
                    
            <form action="{{route('a_c_sorting')}}" method="POST" >
                    @csrf
                    <div class="form-group">
                    <select class="custom-select  mb-3" id="sorting" name="sorting">
                            <option value=""> Sorting ... </option>
                            <option value="ai" @if($order === 'ai') {{ __('selected') }} @endif> Ascending by ID</option>
                            <option value="di" @if($order === 'di') {{ __('selected') }} @endif> Desc by ID </option>
                            <option value="at" @if($order === 'at') {{ __('selected') }} @endif> Ascending by title </option>
                            <option value="dt" @if($order === 'dt') {{ __('selected') }} @endif> Desc by title </option>
                            <option value="ac" @if($order === 'ac') {{ __('selected') }} @endif> Ascending by categories </option>
                            <option value="dc" @if($order === 'dc') {{ __('selected') }} @endif> Desc by categories </option>
                    </select>
                    
                    </div>   
            </form>
            </div>

            <div class="col-md-6">
                <form action="{{route('a_c_searching')}}"  method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search by course name,category" id="search_item" 
                        name="search_item" value="@if($res) {{ $res }} @endif"
                        >
                        <div class="input-group-append">
                        <button type="submit" class="btn btn-info" > <i class="fa fa-search" aria-hidden="true"></i>
                            Search </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if ($courses->count())
    @include('session_msg')
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col"> Mark </th>
                <th scope="col"> # </th>
                <th scope="col"> Title </th>
                <th scope="col"> Categories </th>
                <th scope="col"> Instructor </th>
                <th scope="col"> Email </th>
                <th scope="col"> Status </th>
                <th scope="col"> Popular </th>
                <th scope="col"> Featured </th>
                <th scope="col"> Link </th>
                <th scope="col"> Change Price </th>
                <th scope="col"> Delete </th>
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
                    <td> {{ $course->id ?? '' }}</td>
                    <td> {{ $course->course_title ?? '' }}</td>
                    <td> {{ $course->categories_selection ?? '' }}</td>
                    <td> {{ $course->user->name ?? '' }} </td>
                    <td> {{ $course->user->email ?? '' }} </td>                    
                    @php $s = $course->status; @endphp
                    <td> @if($s) 
                        <div class="badge @if($s == "block") {{ __('badge-danger') }} 
                        @elseif($s == "pending") {{ __('badge-warning')}} @elseif($s == "published") {{ __('badge-success')}} @elseif($s == "draft") {{__('badge-danger')}} @endif" > {{ $s ?? '' }} </div> @endif 
                    </td>    
                    <td> {{ $course->isPopular ? 'yes': "No" }} </td>                    
                    <td> {{ $course->isFeatured ? 'yes': "No" }} </td>                    
                    <td> <a href="{{route('user-course', ['slug' => $course->slug ])}}" > Link </a> </td>  
                    <td> <a href="{{route('admin_change_price', compact('course'))}}" > Change Price </a> </td>  
                    <td> <div href="{{route('course_delete', ['course_id' => $course->id ])}}" class="text-danger cursor_pointer c_del_by_a"> Delete </div> </td>  
                </tr>
                <input type="hidden" id="course_status_change" value="{{route('change_course_status')}}">
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
            <div> Sorry, no assignments were found. </div>
        </div>
    @endif
    

    <div class="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" id="course-delete">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-danger text-white">
              <h5 class="modal-title">Delete Course</h5>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div> You are about to delete the course. Deleting the course is irrevisible which means 
                  you cannot undo this once it has been completed. Further, if we find some students
                  enrolled in this course, this course will not be deleted because we promise 
                  our student for life time access 
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <form action="" method="POST" id="del-course-btn">
                  @csrf 
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger" >Delete Course </button>
              </form>                  
            </div>
          </div>
        </div>
      </div>

@endsection

@section('page-js')
    <script src="{{asset('js/admin_courses.js')}}">      
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
         crossorigin="anonymous">
    </script>
    <script>
        $(function(){
            
            $('.c_del_by_a').click(function(){
                let link = $(this).attr('href');
                if(link){
                    $('#del-course-btn').attr('action',link);
                    $('#course-delete').modal('show');
                }else{
                    alert('there is some error');
                }
            });
        });
    </script>
@endsection
