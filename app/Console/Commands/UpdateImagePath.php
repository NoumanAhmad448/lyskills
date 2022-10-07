<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\Page;
use App\Models\Faq;
use Illuminate\Support\Facades\DB;

class UpdateImagePath extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updateImagePath';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command update the image path to the amazon path';

    private $table_info = [
        ["table" => "posts", "col_name" => "upload_img"],
        ["table" => "pages", "col_name" => "upload_img"],
        ["table" => "faqs", "col_name" => "upload_img"],
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
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
        foreach ($this->table_info as $table_ob ) {
            DB::table($table_ob['table'])->update([$table_ob['col_name'] =>
                DB::raw("CONCAT('storage/',".$table_ob['col_name'].")")]);
        }
        return $this->info("updated");
    }
}
