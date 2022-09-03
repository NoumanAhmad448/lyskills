@extends('admin.admin_main')



@section('page-css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
<style>
    #history_filter input{
        border-radius: 10px;
    }
</style>
@endsection

@section('content')
    <div class="container my-5">
        <h1>
            Course Purchase History
        </h1>
        @if($course_history->count())
        <div class="table-responsive my-5" >
            <table class="table" id="history">
                <thead class="thead-dark">
                    <tr>
                      <th scope="col">Course Name</th>
                      <th scope="col">Purchased By</th>
                      <th scope="col">Instructor</th>
                      <th scope="col">Payment</th>
                      <th scope="col"> Method</th>
                      <th scope="col">Date</th>                                                                 
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($course_history as $history)
                        <tr>
                            <th class="text-capitalize"> {{ $history->course->course_title }} </th>
                            <td> {{ $history->user->name }} </td>
                            <td> {{ $history->ins->name }} </td>
                            <td> ${{ $history->amount }}</td>
                            <td> {{ $history->pay_method }}</td>
                            <td> {{ $history->created_at }}</td>                        
                        </tr>                        
                    @endforeach                   
                  </tbody>
                  <tfoot>
                    <th scope="col">Course Name</th>
                    <th scope="col">Student Name</th>
                    <th scope="col">Instructor Name</th>
                    <th scope="col">Payment</th>
                    <th scope="col">Method</th>
                    <th scope="col">Date</th>                                          
                  </tfoot>
                </table>                
          </div>
          @else 
            <div class="jumbotron bg-white text-center text-dark">
                <h2> No Course History found</h2>
                <div> Neither user has purchased any of your course yet </div>
            </div>
        @endif
    </div>
@endsection

@section('page-js')
{{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script>
    $(function(){
        $('#history tfoot th').each( function () {
             var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        } );
        $('#history').DataTable({            
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
        // $('#history_filter').addClass('form-control');
    });
</script>
@endsection

<script>
    $('#u_payment').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');
</script>