<?php

namespace App\Http\Response;

use App\Http\Contracts\PostsContract;
use App\Models\Post;
use Exception;

class PostsResponse implements PostsContract

{
    public function toResponse($request)
    {
        try {
            $title = __('messages.post');
            $desc = __('description.posts');
            $posts = Post::where('status', Post::PUBLISH_STATUS)->orderByDesc('created_at')->simplePaginate(15);
            return $request->wantsJson()
                ? response()->json([
                    "title" => $title,
                    "posts" => $posts,
                    "desc" => $desc
                ])
                : view('public_post.posts', compact('title', 'posts', 'desc'));
        } catch (Exception $th) {
            debug_logs($th->getMessage());
            return back()->with("error", "");
        }
    }
}
