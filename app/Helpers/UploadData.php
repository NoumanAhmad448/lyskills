<?php

namespace App\Helpers;

use App\interfaces\UploadDataIn;
use Illuminate\Support\Facades\Storage;


class UploadData implements UploadDataIn{
    private $dir_path = "";
    private $disk = "";
    private $default_setting = [
        "isImage" => true,
        "isVideo" => false,
        "imageStoragePath" => "storage/img/",
        "videoStoragePath" => "uploads/"
    ];


    public function __construct(){
        $this->dir_path = config("setting.dir_path");
        $this->disk = config('filesystems.default');

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

    public function upload($object, $file_name, $params=[])
    {

        // $this->createDirectory();
        // Never and Ever Call the above funtion

        // upload image
        if($this->default_setting['isImage']){
            if(config("app.debug")){
                $this->default_setting['imageStoragePath'];
            }
            $path = $this->default_setting['imageStoragePath'].time() . uniqid() . str_replace(' ', '-',$file_name);

        }else if($this->default_setting['isVideo']){
            $path = $this->default_setting['videoStoragePath'].time() . uniqid() . str_replace(' ', '-',$file_name);
        }
        debug_logs("Before Uploading...!");
        debug_logs($path);
        $response = "";
        // Check environment
        try{
            if(config('app.env') === 'dev') {
                $response = Storage::disk($this->disk)->put($path, $object);
            } else {
                $response = Storage::disk($this->disk)->put($path, $object);
            }

        }catch(\Exception $e){
            debug_logs($e);
        }
        debug_logs($response);
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