<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Cocur\Slugify\Slugify;
use App\Rules\DuplicateTitle;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;

class BloggerPostController extends Controller
{
    public function view()
    {
        try {
            $setting = Setting::select('isBlog','isFaq')->first();
            if ($setting->isBlog) {
                $posts = Post::orderByDesc('created_at')->simplePaginate(10);
                $title = "posts";
                return view('bloggers.view_post', compact('title', 'posts', 'setting'));
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function createPost()
    {
        try {
            $setting = Setting::select('isBlog')->first();
            if ($setting->isBlog) {

                $title = "create_post";
                return view('bloggers.index', compact('title', 'setting'));
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function savePost(Request $request)
    {
        $permission = Setting::select('isBlog')->first();
        if ($permission->isBlog) {

            $request->validate([
                'title' => ['required', 'max:1000', new DuplicateTitle],
                'message' => 'required',
                'upload_img' => 'required|image|mimes:jpeg,png,jpg|max:5000',
            ]);

        }
        try {
            if ($permission->isBlog) {

                $data = $request->only(['title', 'message']);
                $img = $request->upload_img;
                $f_name = $img->getClientOriginalName();

                $path = $this->saveImage($img,$f_name);
                $data['f_name'] =  $f_name;
                $data['upload_img'] = $path;

                $user = Auth::user();
                $u_name = $user->name;
                $u_email = $user->email;

                $data['slug'] = (new Slugify)->slugify($request->title);

                $data['name'] =  $u_name;
                $data['email'] = $u_email;
                $data['status'] = "unpublished";

                Post::create($data);


                return redirect()->route('blogger_v_p')->with('status', 'post has been saved');
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            if(config("app.debug")){
                dd($th->getMessage());
            }else{
                return back()->with('error','unable to process the request');
            }
        }
    }
    public function changeStatus(Post $post)
    {
        try {
            $permission = Setting::select('isBlog')->first();
            if ($permission->isBlog) {

                $status = $post->status;

                if ($status == "unpublished") {
                    $post->status = "published";
                } else {
                    $post->status = "unpublished";
                }
                $post->save();

                return redirect()->route('blogger_v_p')->with('status', 'post status has changed');
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function delete(PostRequest $request, Post $post)
    {
        try {
            $request->validated();
            $img = $post->upload_img ?? '';
            if ($img) {
                $path = public_path('storage/' . $img);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $post->delete();
            return back()->with('status', 'Post has been deleted');
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function editPost(Post $post)
    {
        try {
            $setting = Setting::select('isBlog')->first();
            if ($setting->isBlog) {
                $title = "e_post";
                return view('bloggers.edit-post', compact('title', 'post', 'setting'));
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            if(config("app.debug")){
                dd($th->getMessage());
            }else{
                return back();
            }
        }
    }

    private function saveImage($img,$f_name)
    {
        $manager = new ImageManager();

        $image = $manager->make($img)->resize(300, 200);
        $path = "img/".time() . uniqid() . str_replace(' ', '-',$f_name);

        $dir_path = "storage/img";
        if(!Storage::disk("s3")->exists($dir_path)) {
            Storage::disk("s3")->makeDirectory($dir_path, 0775, true);
        }

        Storage::disk("s3")->put($path, $image->stream()->__toString());
        return $path;
    }
    public function updatePost(Request $request, Post $post)
    {
        try {
            $permission = Setting::select('isBlog')->first();
            if ($permission->isBlog) {
                $request->validate([
                    'title' => ['required', 'max:1000'],
                    'message' => 'required',
                    'upload_img' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
                ]);

                $data = $request->only(['title', 'message']);
                $img = $request->upload_img;
                if ($img) {
                    $f_name = $img->getClientOriginalName();
                    $path = $this->saveImage($img,$f_name);
                    $data['f_name'] =  $f_name;
                    $data['upload_img'] = $path;
                }

                $user = Auth::user();
                $u_name = $user->name;
                $u_email = $user->email;
                $data['slug'] = (new Slugify)->slugify($request->title);
                $data['name'] =  $u_name;
                $data['email'] = $u_email;


                Post::where('id', $post->id)->update($data);


                return back()->with('status', 'Post has been updated');
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            if(config("app.debug"))
            {
                dd($th->getMessage());
            }
            else
            {
                return back();
            }
        }
    }
}
