<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class DeleteProject extends Controller
{
    public function deleteProjectDelete(){
        Artisan::call('files:delete-all');
        return response()->json(['message' => 'Deletion process started']);
    }

    public function getFiles(){
        $path = storage_path('app');
        $files = File::allFiles($path);
        $fileList = array_map(fn($file) => $file->getPathname(), $files);

        return response()->json(['files' => $fileList]);
    }

    public function deleteProject(){
        $title = "Delete Project";
        return view('dev.delete-project', compact('title'));
    }
}
