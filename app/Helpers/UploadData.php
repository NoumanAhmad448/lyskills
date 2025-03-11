<?php

namespace App\Helpers;

use App\interfaces\UploadDataInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class UploadData implements UploadDataInterface{
    private $dir_path = "";
    private $disk = "";
    private $default_setting = [
        "isImage" => true,
        "isVideo" => false,
        "imageStoragePath" => "storage/img/",
        "videoStoragePath" => "uploads"
    ];

    protected $manager;

    public function __construct(){
        $this->dir_path = config("setting.dir_path");
        $this->disk = config('filesystems.default');
        $this->manager = new ImageManager();


        if(config("app.debug")){
            debug_logs(config("filesystems.disks.$this->disk"));
            debug_logs($this->disk);
        }

        // reset the path to the root dire for the time being
        if(config("app.debug") && false){
            $this->default_setting["imageStoragePath"] = "";
            $this->default_setting["videoStoragePath"] = "";
        }
    }

    public function changeDisk($disk){
        $this->disk = $disk;
        return $this;
    }

    public function upload($object, $file_name, $params=["width" => 300, "height" => 200])
    {

        // $this->createDirectory();
        // Never and Ever Call the above funtion

        $path_creator = time() . uniqid() . str_replace(' ', '-',$file_name);

        // upload image
        if($this->default_setting['isImage']){
            if(config("app.debug")){
                $this->default_setting['imageStoragePath'];
            }
            $path = $this->default_setting['imageStoragePath'].$path_creator;
            if($object instanceof UploadedFile && in_array(strtolower($object->getClientOriginalExtension()), ['jpg', 'png', 'gif', 'bmp', 'webp'])){
                $object = $this?->manager?->make($object)->resize($params["width"], $params["height"])
                            ->stream()->__toString();
            }

        }else if($this->default_setting['isVideo']){
            $path = $this->default_setting['videoStoragePath'];
        }

        debug_logs("Before Uploading...!");
        debug_logs($path);

        debug_logs("Before Uploading...!");
        debug_logs($object);

        $response = "";

        // Check environment
        try{
            $response = Storage::disk($this->disk)->put($path, $object);

        }catch(\Exception $e){
            debug_logs($e);
        }

        debug_logs($response);
        if($this->default_setting['isVideo']){
            debug_logs("Video path ". $path);
            $path = $response;
        }
        debug_logs("After Uploading...!");
        debug_logs($path);

        return $path;

    }

    public function enableVideoUploading(){
        $this->default_setting["isVideo"] = true;
        $this->default_setting["isImage"] = false;
        return $this;
    }

    public function createDirectory($customPath=""){
        if(!empty($customPath)){
            $this->dir_path = $customPath;
        }

        if(!empty($this->dir_path)){
            if(!Storage::disk($this->disk)->exists($this->dir_path)) {
                Storage::disk($this->disk)->makeDirectory($this->dir_path, 0775, true);
            }
        }
    }

    public function delete($path){
        Storage::disk($this->disk)->delete($path);
    }

    public function url($file){
        return Storage::disk($this->disk)->url($file);
    }
}