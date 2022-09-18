<?php

namespace App\Console\Commands;

use App\Models\CourseImage;
use Illuminate\Console\Command;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MoveAllImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:move_files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'move images from the storage img folder to the amazon s3';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    private $dir_path = "storage/img";
    private $storage_path = "storage/";

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // create folder
        if(!Storage::disk("s3")->exists($this->dir_path)) {
            Storage::disk("s3")->makeDirectory($this->dir_path, 0775, true);
        }

        $course_images = CourseImage::all();
        $total_images = CourseImage::count();
        $counter = 0;

        foreach ($course_images as $course_image) {
            $content = Storage::get(public_path()."/".$this->storage_path.$course_image->image_path);
            if(!Storage::disk("s3")->exists($this->storage_path.$course_image->image_path)){
                Storage::disk("s3")->put($this->storage_path.$course_image->image_path, $content);
            }
            $counter+=1;
            $this->info("Remaining ".($total_images-$counter));
            $this->info("_");
        }
        return 0;
    }
}
