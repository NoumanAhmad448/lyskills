<?php

namespace App\interfaces;


interface UploadDataIn{
    public function upload($object, $file_name, $params=[]);
    public function  changeDisk($disk);
}
