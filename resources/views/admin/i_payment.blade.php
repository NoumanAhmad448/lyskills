@extends('admin.admin_main')
@section('page-css')        
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css"> --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
@endsection
@section('content')
    @include('session_msg')
    @if(isset($users) && $users->count())
    <x-instructorscls title="Monthly Payment" :users="$users" >
    </x-instructorscls>
    @else    
        <x-instructor-not-found></x-instructor-not-found>
    @endif
@endsection

  
        

@section('page-js')
    @includeIf('admin.hightlight_option')
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.js"></script>
    <script>
        $('#instructor').DataTable({
            language: {
            searchPlaceholder: "Search Instructors"
        }
        });
    </script>
@endsection