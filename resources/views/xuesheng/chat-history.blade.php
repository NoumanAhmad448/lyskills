<?php 
use App\Models\User;
?>
@extends(config('setting.guest_blade'))


@section('content')
    <div class="container">
        <h1> Chat History</h1>
    </div>
    <div class="container-fluid my-4">
        <a href="{{route('con-ins')}}" class="btn btn-lg btn-website">
            Compose Message to Instructor
        </a>
    </div>

    <div class="containter-fluid">
        <div class="row">
            <div class="col-3">
                @if($all_inss->count())
                    @foreach ($all_inss as $ins)
                        @php 
                            $user = User::where('id',$ins)->first();                        
                        @endphp
                            @if($user)
                                <a href="" class="text-capitalize">{{$user->name }} </a>
                            @endif
                    @endforeach
                @endif
                
            </div>
        </div>
    </div>
@endsection