<?php

namespace App\Http\Controllers;

use App\Models\OtherFiles;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtherFilesController extends Controller
{

    public function index(Request $request, $lec_id)
    {
        try {
            if ($request->ajax()) {

                // dd($request->upload_ot_file);
                $request->validate([
                    'upload_ot_file' => 'required|file|max:1000000|mimes:pdf,zip'
                ]);

                $file = $request->file('upload_ot_file');

                $lecture = Lecture::findOrFail($lec_id);
                if ($lecture->course->user_id != Auth::id()) {
                    abort(403);
                }

                $f_name = $file->getClientOriginalName();
                $f_mimetype = $file->getClientMimeType();

                $path = $file->store('docs', 'public');

                $media = new OtherFiles;
                $media->lecture_id = $lec_id;
                $media->f_path = $path;
                $media->f_name = $f_name;

                $media->f_mimetype = $f_mimetype;
                $media->save();


                return response()->json([
                    'media' => $media,
                    'delete_url' => route('delete_file', ['lec_id' => $lec_id]),
                    'preview_file' => route('prev_file', ['file_id' => $media->id])
                ]);
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function delete($lec_id)
    {

        try {
            $lecture = Lecture::findOrFail($lec_id);
            if ($lecture->course->user_id != Auth::id()) {
                abort(403);
            }

            $file = $lecture->other_file;
            if ($file) {
                $f_path = $file->f_path;
                unlink(public_path('storage/' . $f_path));
                $file->delete();
                return response()->json(
                    [
                        'status' => 'file has been deleted',
                        'other_files_url' => route('other_files', ['lec_id' => $lec_id])
                    ]
                );
            }
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function prev_file(OtherFiles $file_id)
    {
        try {
            $content_path = 'Content_Type:' . $file_id->f_mimetype;
            $headers = array($content_path);
            $f_path = $file_id->f_path;
            $f_name = $file_id->f_name;
            return response()->download(public_path('storage/' . $f_path), $f_name, $headers);
        } catch (\Throwable $th) {
            return back();
        }
    }
}
