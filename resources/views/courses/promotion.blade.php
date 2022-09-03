@extends('courses.dashboard_main')
@php 


$promotions = $course->promotion;


@endphp

@section('content')
    <div class="border bg-white col-md-9 mt-3 p-3">
        <section class="pricing">
            <h1> Coupon </h1>
            <hr>


            <form class="coupon" url="{{route('saveCoupon',compact('course'))}}">
                <div class="row create_btn_row">
                    <div class="col-12">
                        <div class="float-right btn btn-info btn-lg ct_btn" > Create Coupon </div>
                    </div>
                </div>
            
            </form>

            <hr/>

            @if($promotions)
             @foreach ($promotions as $p)
                <form url="{{route('updateCoupon', ['promotion' => $p])}}" class="edit_coupon mt-3">
                    <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-10">
                            <div class="form-group">
                                <input type="text" class="form-control" id="coupon_no" placeholder="Coupon" name="coupon_no" value="{{$p->coupon_code ?? ''}}">
                            </div>
                        </div>
                        <div class="col-2 col-md-1">
                            <div class="btn btn-danger del_coupon" url="{{route('delete_coupon',['promotion' => $p])}}"> Delete </div>
                        </div>
                        <div class="col-6 ml-3 ml-md-0 col-md-1">
                            <button type="submit" class="btn btn-info " > Update </button>
                        </div>
                    </div>
                </div>
                </form>
             @endforeach
            @endif
        </section>
    </div>
@endsection



@section('page-js')
<script src="{{asset('js/promotion.js')}}">   
</script>

@endsection