<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PromotionRequest;
use App\Http\Requests\CouponRequest;
use App\Models\Promotion;


class PromotionController extends Controller
{
    public function promotion(Course $course)
    {
        try {
            if ($course->user_id != Auth::id()) {
                abort(403);
            }
            $promotions = $course->promotion->sortByDesc(function($promotion){
                return $promotion->id;
            });
            return view('courses.promotion', compact('course','promotions'));
        } catch (\Throwable $th) {
            if(config("app.debug")){
                dd($th);
            }else{
                return back();
            }
        }
    }

    public function saveCoupon(PromotionRequest $request, $course)
    {
        try {
            $request->validated();
            $coupon = $request->coupon_no;
            $is_free = $request->is_free;

            $date_time = $request->date_time;
            $no_of_coupons = $request->no_of_coupons;
            $percentage = $request->percentage;

            if ($coupon && is_xss($coupon)) {
                abort(403);
            }
            if ($is_free && is_xss($is_free)) {
                abort(403);
            }
            if ($percentage && is_xss($percentage)) {
                abort(403);
            }
            if ($no_of_coupons && is_xss($no_of_coupons)) {
                abort(403);
            }

            $course = Course::findOrFail($course);
            if(!$is_free){
                if(!$date_time && !$no_of_coupons && !$percentage){
                    $is_free="on";
                }
            }
            $coupon_id= $request->coupon_id;
            if($coupon_id){
                $promotion = Promotion::where("id",$coupon_id)->first();
            }else{
                $promotion = new Promotion;
            }
            $promotion->course_id = $course->id;
            $promotion->coupon_code = $coupon;
            if($is_free && $is_free=="on"){
                $promotion->is_free=1;
            }else{
                $promotion->is_free=false;
            }
            if($date_time){
                $promotion->date_time=dateFormat($date_time);
            }
            if($no_of_coupons){
                $promotion->no_of_coupons=$no_of_coupons;
            }
            if($percentage){
                $promotion->percentage=$percentage;
            }

            $promotion->save();
            return response()->json([
                'status' => 'saved',
                'edit'  => route('updateCoupon', compact('promotion')),
                'delete' => route('delete_coupon', compact('promotion')),
                'coupon' => $coupon
            ]);
        } catch (\Throwable $th) {
            if(config("app.debug")){
                dd($th);
            }else{
                return response()->json([
                    "message" => "something went wrong"]);
            }
        }
    }

    public function updateCoupon(CouponRequest $request, $promotion)
    {
        try {
            $request->validated();
            $coupon = $request->coupon_no;

            if (is_xss($coupon)) {
                abort(403);
            }
            $promotion = Promotion::findOrFail($promotion);
            $promotion->coupon_code = $coupon;
            $promotion->save();

            return response()->json([
                'coupon' => $coupon
            ]);
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function deleteCoupon(Promotion $promotion)
    {
        try {
            if (Auth::id() == $promotion->course->user_id) {
                $promotion->delete();
                return response()->json(['status' => 'deleted']);
            }
        } catch (\Throwable $th) {
            return back();
        }
    }
}
