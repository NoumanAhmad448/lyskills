@extends('admin.admin_main')
@section('page-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <h1> Users </h1>
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-4">
                <form  method="POST" action="{{route('sorting_users')}}">
                    @csrf
                    <div class="form-group d-flex align-items-center">
                        <label for="sorting" class="mr-2 d-none d-md-block"> Sorting </label>
                        <select class="custom-select custom-select mb-3" id="sorting" name="sorting">
                            <option value=""> Choose Sorting  </option>
                            <option value="ai" @if($order === 'ai') {{ __('selected') }} @endif >Ascending by ID</option>
                            <option value="di" @if($order === 'di') {{ __('selected') }} @endif >Descending by ID</option>
                            <option value="an" @if($order === 'an') {{ __('selected') }} @endif >Ascending by Name</option>
                            <option value="dn" @if($order === 'dn') {{ __('selected') }} @endif >Descending by Name</option>
                            <option value="ae" @if($order === 'ae') {{ __('selected') }} @endif >Ascending by Email</option>
                            <option value="de" @if($order === 'de') {{ __('selected') }} @endif >Descending by Email</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <form action="{{route('search_users')}}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search by name or email"
                            value="@if($search_item) {{$search_item}} @endif"
                        id="search_item" name="search_item"
                            >
                        <div class="input-group-append">
                          <button type="submit" class="btn btn-info" id="search"> <i class="fa fa-search" aria-hidden="true"></i>
                               Search
                        </button>
                        </div>
                      </div>
                </form>
            </div>
        </div>
    </div>
    
    @if($users->count())               
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th> # </th>
                <th> Name</th>
                <th> Email</th>
                <th> Student</th>
                <th> Instructor </th>
                <th> date </th>
                <th> Edit </th>
                <th> Delete </th>
            </tr>
            </thead>
            <tbody>
                    @foreach ($users as $user)                    
                        <tr class="u_record">
                            <th>  {{ $user->id ?? ''}} </th>
                            <td> {{ $user->name ?? '' }}</td>
                            <td> {{ $user->email ?? '' }} </td>
                            <td> {{ $user->is_student ? 'Yes' : 'No' }} </td>
                            <td> 
                            {{ $user->is_instructor ? 'Yes' : 'No' }} </td>
                            <td>
                                {{$user->created_at ?? ''}}
                            </td>
                            <td> <a href="{{route('a_e_users',compact('user'))}}" > <i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a> </td>
                            <td> <div class="cursor_pointer delete" link="{{route('a_d_users',compact('user'))}}" > <i class="fa fa-trash" aria-hidden="true"></i> </div> </td>
                        </tr>
                        
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center jumbotron bg-light">
            <img src="{{asset('img/not_found.png')}}" alt="Lyskills" class="img-fluid img-thumbnail rounded-pill" width="100"/>

            <div> Sorry, No record was found. <b> Please refine your search by trying another option </b> </div>
        </div>
    @endif
    <div class="d-flex justify-content-end mb-5">
        <div> {{ $users->links() }} </div>
    </div>

@endsection



@section('page-js')
    <script src="{{asset('js/users.js')}}"></script>
@endsection