@extends(config('setting.guest_blade'))

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
            Payment History
        </h1>
        @if($course_history->count())
        <div class="table-responsive my-5" >
            <table class="table" id="history">
                <thead class="thead-dark">
                    <tr>
                      <th scope="col">Course Name</th>
                      <th scope="col">Instructor Name</th>
                      <th scope="col">Price</th>
                      <th scope="col">Date</th>                      
                      <th scope="col">Payment Method</th>                      
                      <th scope="col">Course Link</th>                      
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($course_history as $history)
                        <tr>
                            <th class="text-capitalize"> {{ $history->course->course_title }} </th>
                            <td> {{ $history->ins->name }} </td>
                        <td> ${{ $history->amount }}</td>
                        <td> {{ $history->created_at }}</td>
                        <td> {{ $history->pay_method }}</td>
                        <td> <a href="{{ route('user-course', ['slug' => $history->course->slug]) }}" class="text-primary" target="_blank"> Link </a> </td>
                        </tr>                        
                    @endforeach                   
                  </tbody>
                  <tfoot>
                    <th scope="col">Course Name</th>
                    <th scope="col">Instructor Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Date</th>                      
                    <th scope="col">Payment Method</th> 
                  </tfoot>
                </table>                
          </div>
          @else 
            <div class="jumbotron bg-white text-center text-dark">
                <h2> No Course History found</h2>
                <div> You did not find any course yet </div>
            </div>
        @endif
    </div>
@endsection

@section('script')
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
    }
        
        });
        // $('#history_filter').addClass('form-control');
    });
</script>
@endsection