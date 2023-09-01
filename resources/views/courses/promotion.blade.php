@extends('courses.dashboard_main')
@php 


$promotions = $course->promotion;


@endphp
@section("page-css")
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endsection
@section('content')
    <div class="border bg-white col-md-9 mt-3 p-3">
        <section class="pricing">
            <h1> Coupon </h1>
            <hr>


            <form class="coupon ml-3" url="{{route('saveCoupon',compact('course'))}}">
                <h3 class="row"> Create a new Coupon</h3>
                <div class="row create_btn_row">
                @if(config("setting.coupon_form"))
                    <section class="c_con mt-4" >
                    <div class="form-group">
                        <label for="coupon_no"> Coupon Name </label>
                        <input type="text" class="form-control" id="coupon_no" placeholder="Coupon" name="coupon_no">
                        <small class="form-text text-muted">write any specific word of your choice and share it with others
                            to let them access your course at specific cost or totally free.
                        </small>
                    </div>
                    <div class="row my-2">
                        <div class="col">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_free" name="is_free">
                                <label for="is_free" class="form-check-label">set free?</label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group" id="set_free">
                        <div class="row">
                        <div class="col-3">
                            <label for="date_time">Until Valid Date?</label>
                            <input type="text" class="form-control" id="date_time" name="date_time">
                        </div>
                        <div class="col-3">
                            <label for="no_of_coupons">Allowed Coupons?</label>
                            <input type="number" class="form-control" id="no_of_coupons" name="no_of_coupons">
                        </div>
                        <div class="col-3">
                            <label for="percent"> Set Percentage %</label>
                            <select class='form-control' id='percentage' name='percentage'>
                                @for($i=1;$i<=100;$i++)
                                    <option value="{{ $i }}"> {{ $i }} % </option>
                                @endfor
                            </select>
                        </div>
                        </div>
                    </div>
                    <div class="err_msg text-danger my-2"> </div>
                    <button type="submit" class="btn btn-info"> Create </button>
                </section>
                @else
                    <div class="col-12">
                        <div class="float-right btn btn-info btn-lg ct_btn" > Create Coupon </div>
                    </div>
                @endif
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
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="{{asset('js/promotion.js')}}">   
</script>

@endsection