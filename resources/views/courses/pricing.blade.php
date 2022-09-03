@extends('courses.dashboard_main')
@php 


$pricing = $course->price;
$price = null;
$free = null;
if(isset($pricing)){
    $price = $pricing->pricing;
    $free = $pricing->is_free;
}



@endphp

@section('content')
<div class="border bg-white col-md-9 mt-3 p-3">

    <section class="pricing">
        <h1> Course Pricing</h1>
        <hr>
        @include('session_msg')
        <form url="{{route('pricing',compact('course'))}}" class="p_price" >
            <div class="form-group">
                <label for="pricing">Course Price</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" >$</span>
                    </div>
                    <input type="number" min="1" max="500" class="form-control pricing" id="pricing" name="pricing" placeholder="Set Course Price"
                     value="@if($pricing && $price){{ $price }}@endif" @if(!$price && isset($pricing)) {{ __('disabled') }} @endif>
                     <div id="pricing_err" class="text-danger"></div>
                    </div>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="free" name="free" @if($pricing && $free) {{ __('checked')}} @endif>
                    <label class="form-check-label" for="free">Mark Free</label>
                </div>
                
                <button type="submit" class="btn btn-info" @if($price || $free) @else {{__('disabled')}} @endif ><i class="las la-save"></i>Save</button>
            </form>            
    </section>

</div>
@endsection



@section('page-js')
<script src="{{asset('js/price.js')}}">   
</script>

@endsection