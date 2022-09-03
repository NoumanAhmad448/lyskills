<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Faq;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cocur\Slugify\Slugify;
use App\Rules\FaqDuplicateTitle;

class BloggerFaqController extends Controller
{
    public function view()
    {
        try {
            $setting = Setting::select('isFaq','isBlog')->first();
            if ($setting->isFaq) {
                $faqs = Faq::orderByDesc('created_at')->simplePaginate(10);
                $title = "faqs";
                return view('bloggers.view_faq', compact('title', 'faqs', 'setting'));
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            return back();
        }
    }


    public function createFaq()
    {
        try {
            $setting = Setting::select('isFaq')->first();
            if ($setting->isFaq) {
                $title = "create_faq";
                return view('bloggers.create_faq', compact('title', 'setting'));
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function saveFaq(Request $request)
    {
        $setting = Setting::select('isFaq')->first();
        if ($setting->isFaq) {
            $request->validate([
                'title' => ['required', 'max:1000', new FaqDuplicateTitle],
                'message' => 'required',
                'upload_img' => 'required|image|mimes:jpeg,png,jpg|max:5000',
            ]);
        }
        try {
            if ($setting->isFaq) {
                $data = $request->only(['title', 'message']);
                $img = $request->upload_img;
                $f_name = $img->getClientOriginalName();
                $path = $img->store('img');
                $data['f_name'] =  $f_name;
                $data['upload_img'] = $path;

                $user = Auth::user();
                $u_name = $user->name;
                $u_email = $user->email;

                $data['slug'] = (new Slugify)->slugify($request->title);

                $data['name'] =  $u_name;
                $data['email'] = $u_email;
                $data['status'] = "unpublished";

                Faq::create($data);


                return redirect()->route('blogger_v_faq')->with('status', 'Faq has been created');
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function changeStatus(Faq $faq)
    {

        try {
            $setting = Setting::select('isFaq')->first();
            if ($setting->isFaq) {
                $status = $faq->status;

                if ($status == "unpublished") {
                    $faq->status = "published";
                } else {
                    $faq->status = "unpublished";
                }
                $faq->save();

                return redirect()->route('blogger_v_faq')->with('status', 'Faq status has changed');
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function delete(PostRequest $request, Faq $faq)
    {
        try {
            $request->validated();
            $img = $faq->upload_img ?? '';
            if ($img) {
                $path = public_path('storage/' . $img);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $faq->delete();
            return back()->with('status', 'Faq has been deleted');
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function editFaq(Faq $faq)
    {
        try {
            $setting = Setting::select('isFaq')->first();
            if ($setting->isFaq) {
                $title = "e_faq";
                return view('bloggers.edit_faq', compact('title', 'faq', 'setting'));
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function updateFaq(Request $request, Faq $faq)
    {
        try {
            $setting = Setting::select('isFaq','isBlog')->first();
            if ($setting->isFaq) {
                $request->validate([
                    'title' => ['required', 'max:1000'],
                    'message' => 'required',
                    'upload_img' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
                ]);

                $data = $request->only(['title', 'message']);
                $img = $request->upload_img;
                if ($img) {
                    $f_name = $img->getClientOriginalName();
                    $path = $img->store('img');
                    $data['f_name'] =  $f_name;
                    $data['upload_img'] = $path;
                }

                $user = Auth::user();
                $u_name = $user->name;
                $u_email = $user->email;
                $data['slug'] = (new Slugify)->slugify($request->title);
                $data['name'] =  $u_name;
                $data['email'] = $u_email;


                Faq::where('id', $faq->id)->update($data);


                return redirect()->route('blogger_edit_faq', compact('faq'))->with('status', 'Faq has been updated');
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            return back();
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('blogger-login')->with('status', 'You are logged out');
    }
}
