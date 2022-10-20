<?php

namespace App\Console\Commands;

use App\Mail\TestingMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SendEmailToUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:dir';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send an email';

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
        try{
            mkdir(app_path("new_dir"));

        }catch(\Exception $e){
            dd($e->getMessage());
        }
        return 0;
    }
}
