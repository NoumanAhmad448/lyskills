<?php

namespace App\Http\Controllers;

use App\Helpers\UploadData;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cocur\Slugify\Slugify;
use App\Rules\DuplicateTitle;
use Intervention\Image\ImageManager;

class AdminPostController extends Controller
{
    public function view()
    {
        try {
            $posts = Post::orderByDesc('created_at')->simplePaginate(10);
            $title = "posts";
            return view('admin.view_post', compact('title', 'posts'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function createPost()
    {

        try {
            $title = "create_post";
            return view('admin.create_post', compact('title'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function savePost(Request $request)
    {

            $request->validate([
                'title' => ['required', 'max:1000', new DuplicateTitle],
                'message' => ['required'],
                'upload_img' => ['required','image','mimes:jpeg,png,jpg','max:5000'],
            ]);

        try {

            $data = $request->only(['title', 'message']);
            $img = $request->upload_img;
            $f_name = $img->getClientOriginalName();
            // $path = $img->store('img','public');

            $manager = new ImageManager();
            $image = $manager->make($img)->resize(500, 500);
            $uploadData = new UploadData();
            $path = $uploadData->upload($image->stream()->__toString(), $f_name);

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


            return redirect()->route('admin_v_p')->with('status', 'post has been saved');
        } catch (\Throwable $th) {
            return back()->with('error', 'unable to process it'. config("app.debug") ? $th->getMessage(): "");
        }
    }
    public function changeStatus(PostRequest $request, Post $post)
    {
        try {
            $request->validated();
            $status = $post->status;

            if ($status == "unpublished") {
                $post->status = "published";
            } else {
                $post->status = "unpublished";
            }
            $post->save();

            return redirect()->route('admin_v_p')->with('status', 'post status has changed');
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
            $title = "e_post";
            return view('admin.edit-post', compact('title', 'post'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function updatePost(Request $request, Post $post)
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


            Post::where('id', $post->id)->update($data);


            return back()->with('status', 'Post has been updated');
        } catch (\Throwable $th) {
            return back();
        }
    }
}
