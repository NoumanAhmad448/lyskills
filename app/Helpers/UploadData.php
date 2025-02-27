<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class UploadData{
    private $dir_path = "";
    private $disk = "";
    private $default_setting = [
        "isImage" => true, 
        "isVideo" => false, 
        "imageStoragePath" => "storage/img/",
        "videoStoragePath" => "upload/"
    ];


    public function __construct(){
        $this->dir_path = config("setting.dir_path");
        $this->disk = config('app.env') === 'local' ? 'public' : 's3';

        if(config("app.debug")){
            dump(config("filesystems.disks.$this->disk"));
            dump($this->disk);
        }
    }

    public function upload($object, $file_name, $params=[])
    {
        if(!empty($params)){
            if(!empty($params['isVideo'])){
                $default_setting['isVideo'] = true;
                $default_setting['isImage'] = false;
            }
        }

        // $this->createDirectory();

        // upload image
        if($this->default_setting['isImage']){
            $path = $this->default_setting['imageStoragePath'].time() . uniqid() . str_replace(' ', '-',$file_name);
            
            // Check environment
            if(config('app.env') === 'local') {
                Storage::disk('public')->put($path, $object);
            } else {
                Storage::disk("s3")->put($path, $object);
            }
            
            return $path;
        }
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
}