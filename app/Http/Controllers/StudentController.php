<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\WishList;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function wishlistCourse($slug)
    {
        try {
            $c = Course::where('slug', $slug)->first();
            if (!$c) {
                abort(404);
            }
            $u_id = auth()->id();
            if (WishList::where('user_id', auth()->id())->where('c_id', $c->id)->first()) {
                return redirect()->route('get-wishlist-course');
            }
            WishList::create(['user_id' => $u_id, 'c_id' => $c->id]);
            return redirect()->route('get-wishlist-course');
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function getWishlistCourse()
    {
        try {
            $title = 'WishLists';
            $courses = auth()->user()->wishLists()->select('c_id')->orderByDesc('updated_at')->simplePaginate(15);
            return view('student.wish-list', compact('title', 'courses'));
        } catch (\Throwable $th) {
            if(config("app.debug")){
                dd($th->getMessage());
            }else{
                return back();
            }
        }
    }
    public function removeFromWishlist($slug)
    {
        try {
            $course = Course::where('slug', $slug)->first();
            if (!$course) {
                return back();
            }
            $w = WishList::where('user_id', auth()->id())->where('c_id', $course->id)->first();
            if (!$w) {
                return back();
            }
            $w->delete();
            return back();
        } catch (\Throwable $th) {
            return back();
        }
    }
}
