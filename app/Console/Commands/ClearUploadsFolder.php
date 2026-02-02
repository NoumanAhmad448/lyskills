<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearUploadsFolder extends BaseCron
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uploads:clear';

    protected $description = 'Delete all files from public/storage/uploads';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function runCron()
    {

        $path = public_path('storage/uploads');

        if (!is_dir($path)) {
            $this->error('Uploads directory does not exist.');
            return Command::FAILURE;
        }

        $files = glob($path . '/*');

        if (empty($files)) {
            $this->info('No files found in uploads folder.');
            return Command::SUCCESS;
        }

        foreach ($files as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }

        $this->info('All files in storage/uploads have been deleted.');

        return Command::SUCCESS;
    }
}
