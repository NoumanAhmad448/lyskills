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

            return view('courses.promotion', compact('course'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function saveCoupon(PromotionRequest $request, $course)
    {
        try {
            $request->validated();
            $coupon = $request->coupon_no;

            if (is_xss($coupon)) {
                abort(403);
            }
            $course = Course::findOrFail($course);

            $promotion = new Promotion;
            $promotion->course_id = $course->id;
            $promotion->coupon_code = $coupon;
            $promotion->save();

            return response()->json([
                'status' => 'saved',
                'edit'  => route('updateCoupon', compact('promotion')),
                'delete' => route('delete_coupon', compact('promotion')),
                'coupon' => $coupon
            ]);
        } catch (\Throwable $th) {
            return back();
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
