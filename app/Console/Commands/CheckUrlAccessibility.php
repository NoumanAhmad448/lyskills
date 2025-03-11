<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CheckUrlAccessibility extends Command
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
    public function handle()
    {
        // Define the URLs to check
        $urls = [
            'image' => config('setting.s3Url') . 'storage/img/174074848467c1b6c407fc0Ly-skills-Web-Page-1.jpg',
            'video' => config('setting.s3Url') . 'uploads/ZwVFzN6Pntp2uqlgUjXgmO7yo5UEX3GHeovZbCX3.mp4'
        ];

        // Check each URL
        foreach ($urls as $type => $url) {
            $this->info("Checking {$type} URL: {$url}");

            try {
                // Send a HEAD request to check the status code
                $response = Http::head($url);

                if ($response->successful()) {
                    $this->info("✅ {$type} URL is accessible. Status code: " . $response->status());
                    return 0; // Command executed successfully
                } else {
                    $msg = __("error.slack_err_msg", ['type' => $type, "msg" => $response->status()]);
                    throw_exception($msg);
                    $this->error($msg);
                }
            } catch (\Exception $e) {
                $this->error(__("error.slack_err_msg", ['type' => $type, "msg" => $e->getMessage()]));
            }
        }

    }
}
