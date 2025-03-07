<?php

namespace App\interfaces;


interface UploadDataInterface{
    public function upload($object, $file_name, $params=[]);
    public function  changeDisk($disk);
}
