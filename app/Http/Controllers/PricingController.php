<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Pricing;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PricingRequest;
use Illuminate\Support\Facades\DB;

class PricingController extends Controller
{
    public function pricing(Course $course)
    {
        try {
            if ($course->user_id != Auth::id()) {
                abort(403);
            }

            return view('courses.pricing', compact('course'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function savePricing(PricingRequest $request, $course)
    {
        try {
            $request->validated();
            $course = Course::findOrFail($course);
            $free = $request->boolean('free');

            $course_price = $course->price;


            if ($free && $course_price) {

                $course_price->is_free = $free ? 1 : 0;
                $course_price->pricing = null;
                $course_price->save();
                $this->SaveStatus($course->id);
                return response()->json([
                    'status' => 'saved'
                ]);
            } else if ($free) {

                $c_price = new Pricing;
                $c_price->course_id = $course->id;
                $c_price->pricing = null;
                $c_price->is_free = $free ? 1 : 0;
                $c_price->save();
                $this->SaveStatus($course->id);

                return response()->json([
                    'status' => 'saved'
                ]);
            }


            $price = $request->pricing;

            if (isset($price) && is_xss($price)) {
                abort(403);
            }

            if (isset($price) && $course_price) {

                $course_price->pricing = $price;
                $course_price->is_free = false;
                $course_price->save();
                $this->SaveStatus($course->id);
                return response()->json([
                    'status' => 'saved'
                ]);
            } else if (isset($price)) {
                $c_price = new Pricing;
                $c_price->course_id = $course->id;
                $c_price->pricing = $price;
                $c_price->is_free = 0;
                $c_price->save();
                $this->SaveStatus($course->id);

                return response()->json([
                    'status' => 'saved'
                ]);
            }

            return back()->with('error', 'must choose one item');
        } catch (\Throwable $th) {
            return back();
        }
    }


    public function SaveStatus($course_id)
    {
        try {
            DB::table('course_statuses')
                ->where('course_id', $course_id)
                ->update(['pricing' => 10]);
        } catch (\Throwable $th) {
            return back();
        }
    }
}
