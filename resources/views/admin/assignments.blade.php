@extends('admin.admin_main')
@php use Illuminate\Support\Facades\Storage; @endphp
@section('content')
    <h1> Assignments </h1>
    <div class="row justify-content-end mb-3">
        <div class="col-md-3">         
                
           <form action="{{route('a_a_sorting')}}" method="POST" >
                @csrf
                <div class="form-group">
                   <select class="custom-select custom-select mb-3" id="sorting" name="sorting">
                        <option value=""> Sorting ... </option>
                        <option value="ai" @if($order === 'ai') {{ __('selected') }} @endif> Ascending by ID</option>
                        <option value="di" @if($order === 'di') {{ __('selected') }} @endif> Desc by ID </option>
                        <option value="an" @if($order === 'an') {{ __('selected') }} @endif> Ascending by name </option>
                        <option value="dn" @if($order === 'dn') {{ __('selected') }} @endif> Desc by name </option>
                  </select>
                
                </div>   
          </form>
        </div>

        <div class="col-md-6">
            <form action="{{route('a_a_searching')}}" class="post" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search by course name" id="search_item" name="search_item"                    
                    >
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-info" > <i class="fa fa-search" aria-hidden="true"></i>
                        Search </button>
                    </div>
                  </div>
            </form>
        </div>
    </div>
  
    @if ($asses->count())
        <div class="table-responsive">

            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Link</th>
                    <th scope="col">Course Name</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($asses as $ass)                    
                    <tr>
                        <th scope="row"> {{ $ass->id ?? ''}} </th>
                        <td> {{ reduceCharIfAv($ass->ass_f_name,15) ?? '' }} </td>
                        <td> <a href="{{ Storage::url($ass->ass_f_path) }}" target="_blank"> Link </a> </td>
                        <td> {{ $ass->lecture->course->course_title}} </td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
        <div class="text-md-right text-center mb-5 mb-md-0">
            {{ $asses->links() }}

        </div>
    @else
        <div class="jumbotron bg-light text-center">
            <img src="{{asset('img/not_found.png')}}" alt="Lyskills" class="img-fluid img-thumbnail rounded-pill" width="100"/>
            <div> Sorry, no assignments were found. </div>
        </div>
    @endif
@endsection


@section('page-js')
    <script>
        $(function(){
            $('#asses').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');
            $('#sorting').change(function(){
                if($(this).val() !== ''){
                    $(this).parents('form').first().submit();
                }
            });

            $( "#search_item" ).keypress(function( ) {
                if ( event.which == 13 && $(this).val() !== '') {
                    $(this).parents('form').first().submit();
                }
            });
        });
    </script>
@endsection