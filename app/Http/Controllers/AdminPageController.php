<?php

namespace App\Http\Controllers;

use App\Helpers\UploadData;
use App\Http\Requests\PostRequest;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cocur\Slugify\Slugify;
use App\Rules\PageDuplicateTitle;
use Intervention\Image\ImageManager;

class AdminPageController extends Controller
{
    public function view()
    {
        try {
            $pages = Page::orderByDesc('created_at')->simplePaginate(10);
            $title = "pages";
            return view('admin.view_page', compact('title', 'pages'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function createPage()
    {

        try {
            $title = "create_page";
            return view('admin.create_page', compact('title'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function savePage(Request $request)
    {

        try {
            $request->validate([
                'title' => ['required', 'max:1000', new PageDuplicateTitle],
                'message' => 'required',
                'upload_img' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
            ]);

            $data = $request->only(['title', 'message']);
            $img = $request->upload_img;
            if ($img) {
                $f_name = $img->getClientOriginalName();
                $manager = new ImageManager();
                $image = $manager->make($img)->resize(500, 500);
                $uploadData = new UploadData();
                $path = $uploadData->upload($image->stream()->__toString(), $f_name);

                $data['f_name'] =  $f_name;
                $data['upload_img'] = $path;
            }

            $user = Auth::user();
            $u_name = $user->name;
            $u_email = $user->email;

            $data['slug'] = (new Slugify)->slugify($request->title);

            $data['name'] =  $u_name;
            $data['email'] = $u_email;
            $data['status'] = "unpublished";

            Page::create($data);


            return redirect()->route('admin_v_page')->with('status', 'Page has been created');
        } catch (\Throwable $th) {
            return back()->with('error', "unable to process it".config("app.debug") ? $th->getMessage(): "");
        }
    }
    public function changeStatus(PostRequest $request, Page $page)
    {
        try {
            $request->validated();
            $status = $page->status;

            if ($status == "unpublished") {
                $page->status = "published";
            } else {
                $page->status = "unpublished";
            }
            $page->save();

            return redirect()->route('admin_v_page')->with('status', 'Page status has changed');
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function delete(PostRequest $request, Page $page)
    {
        try {
            $request->validated();
            $img = $page->upload_img ?? '';
            if ($img) {
                $path = public_path('storage/' . $img);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $page->delete();
            return back()->with('status', 'Page has been deleted');
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function editPage(Page $page)
    {
        try {
            $title = "e_page";
            return view('admin.edit-page', compact('title', 'page'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function updatePage(Request $request, Page $page)
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

                $manager = new ImageManager();
                $image = $manager->make($img)->resize(500, 500);
                $uploadData = new UploadData();
                $path = $uploadData->upload($image->stream()->__toString(), $f_name);

                $data['f_name'] =  $f_name;
                $data['upload_img'] = $path;
            }

            $user = Auth::user();
            $u_name = $user->name;
            $u_email = $user->email;
            $data['slug'] = (new Slugify)->slugify($request->title);
            $data['name'] =  $u_name;
            $data['email'] = $u_email;


            Page::where('id', $page->id)->update($data);


            return redirect()->route('admin_edit_page', compact('page'))->with('status', 'Page has been updated');
        } catch (\Throwable $th) {
            return back()->with('error', "unable to process it".config("app.debug") ? $th->getMessage(): "");
        }
    }
}
