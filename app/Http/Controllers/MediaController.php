<?php

namespace App\Http\Controllers;

use App\Models\Media;

class MediaController extends Controller
{
    public function show()
    {
        try {
            if (isAdmin()) {
                $title = 'media';
                $media = Media::orderByDesc('created_at')->simplePaginate(15);
                return view('admin.view_media', compact('title', 'media'));
            }
        } catch (\Throwable $th) {
            return back();
        }
    }
}
