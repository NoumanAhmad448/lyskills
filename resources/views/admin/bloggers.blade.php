@extends('admin.admin_main')

@section('page-css')
    @livewireStyles
@endsection

@section('content')
    @livewire('bloggers',['users' => $users])
@endsection


@section('page-js')

  
    

@endsection