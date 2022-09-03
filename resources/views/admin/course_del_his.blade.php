@extends('admin.admin_main')
@section('page-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <h1>
        Course Delete History
    </h1>      
    @if (isset($history) && $history->count())
    @include('session_msg')
    <div class="table-responsive">
        <table class="table table-hover"  id="example">
            <thead>
            <tr>
                {{-- <th scope="col"> Mark </th> --}}
                <th scope="col"> # </th>
                <th scope="col"> Course Name </th>
                <th scope="col"> Name </th>
                <th scope="col"> Email </th>
                <th scope="col"> Is Admin </th>
                <th scope="col"> Date of Deletion </th>              
            </tr>
            </thead>
            <tbody>
                @foreach ($history as $h)                
                <tr>                    
                    <td> {{ $h->id ?? '0' }}</td>
                    <td> {{ $h->course_name ?? 'Unknown Course' }}</td>
                    <td class="text-capitalize"> {{ $h->person_name ?? 'Unknown Person' }}</td>                   
                    <td > {{ $h->email ?? 'Unknown Email' }}</td>                   
                    <td class="text-capitalize"> {{ $h->is_admin ? 'Yes' : 'No' }}</td>                   
                    <td class='text-danger'> {{ $h->created_at->format('d-M-Y') ?? '' }}</td>                   
                </tr>                
                @endforeach
            
            </tbody>
        </table>
    </div>
    
    @else
        <div class="jumbotron bg-light text-center">
            <img src="{{asset('img/not_found.png')}}" alt="Lyskills" class="img-fluid img-thumbnail rounded-pill" width="100"/>
            <div> Nothing to show here </div>
        </div>
    @endif  

       

@endsection

@section('page-js')
   
    <script>
            $('#del_cou_his').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');

    </script>  
    

    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script>
         $('#example').DataTable({
            language: {
                searchPlaceholder: "Search records"
            },
            "pageLength": 25,
            order:[[0,"desc"]]
         });
    </script>


@endsection
