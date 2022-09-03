@extends('admin.admin_main')
@section('page-css')
    @livewireStyles
@endsection

@section('content')
    @livewire('edit-blogger', ['user' => $user])
@endsection

@section('page-js')
    @livewireScripts
@endsection