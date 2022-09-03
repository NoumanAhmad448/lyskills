<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cocur\Slugify\Slugify;
use App\Rules\FaqDuplicateTitle;
use Exception;

class AdminFaqController extends Controller
{
    public function view()
    {
        try {
            $faqs = Faq::orderByDesc('created_at')->simplePaginate(10);
            $title = "faqs";
            return view('admin.view_faq', compact('title', 'faqs'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function createFaq()
    {

        
        try {
            $title = "create_faq";
            return view('admin.create_faq', compact('title'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function saveFaq(Request $request)
    {

        $request->validate([
            'title' => ['required', 'max:1000', new FaqDuplicateTitle],
            'message' => 'required',
            'upload_img' => 'required|image|mimes:jpeg,png,jpg|max:5000',
        ]);
        try {

            $data = $request->only(['title', 'message']);
            $img = $request->upload_img;
            $f_name = $img->getClientOriginalName();
            $path = $img->store('img','public');            
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


            return redirect()->route('admin_v_faq')->with('status', 'Faq has been created');
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function changeStatus(PostRequest $request, Faq $faq)
    {
        try {
            $request->validated();
            $status = $faq->status;

            if ($status == "unpublished") {
                $faq->status = "published";
            } else {
                $faq->status = "unpublished";
            }
            $faq->save();

            return redirect()->route('admin_v_faq')->with('status', 'Faq status has changed');
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
        } catch (Exception $e) {
            return back();
        }
    }

    public function editFaq(Faq $faq)
    {
        try {
            $title = "e_faq";
            return view('admin.edit_faq', compact('title', 'faq'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function updateFaq(Request $request, Faq $faq)
    {
        try {
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


            return redirect()->route('admin_edit_faq', compact('faq'))->with('status', 'Faq has been updated');
        } catch (\Throwable $th) {
            return back();
        }
    }
}
