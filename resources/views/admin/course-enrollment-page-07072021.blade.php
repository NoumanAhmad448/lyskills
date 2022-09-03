@extends('admin.admin_main')
@section('page-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <style>
        #history_filter input{
            border-radius: 10px;
        }
    </style>
@endsection


@section('content')
    <h1> Total number of Enrollments   </h1> <span class="badge badge-success"> Total Enrollment {{ $total_enrollment ?? ''}} </span>
    
    @if($users && $users->count())
        <div class="table-responsive mt-5">
            <table class="table" id="published_courses">
                <thead class="thead-dark">
                    <tr>
                      <th scope="col">#</th>                      
                      <th scope="col">email</th>
                      <th scope="col">name</th>                      
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($users as $course)
                        <tr>
                            <td> {{ $course->user->id ?? '' }}</td>
                            <td> {{ $course->user->name ?? '' }}</td>
                            <td> {{ $course->user->email ?? '' }}</td>                            
                        </tr>                          
                      @endforeach
            </table>
        </div>
    @else 
        <div class="text-center">
            <h3 class="text-danger">
                No course enrollee found 
            </h3>
            <div>
                There is no user enrolled in this course 
            </div>
        </div>
        @endif
@endsection 

@section('page-js')

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script>
    $(function(){
        $('#published_courses tfoot th').each( function () {
             var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        } );
        $('#published_courses').DataTable({            
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
 
                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        },
        language: {
        searchPlaceholder: "Search records"
    },
    "lengthMenu": [[20, 25, 50, -1], [20, 25, 50, "All"]]
        
        });
        
    });
</script>
<script>
    $('#enrollment').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');
</script>
@endsection

