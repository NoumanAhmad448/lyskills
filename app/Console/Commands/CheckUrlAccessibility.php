<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Storage;

class CheckUrlAccessibility extends BaseCron
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:url-accessibility';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the accessibility of URLs (images and videos) by verifying their HTTP status codes.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function runCron()
    {

        Storage::disk('s3')->getAdapter();
    }
}
