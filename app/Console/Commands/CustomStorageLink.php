<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CustomStorageLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:link-custom';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a symbolic link from "public/storage" to "storage/app/public" (skip if already exists)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Paths to the public storage and the storage/app/public directory
        $publicStoragePath = public_path('storage');
        $storageAppPublicPath = storage_path('app/public');

        // Check if the symbolic link already exists
        if (File::exists($publicStoragePath)) {
            $this->info('The symbolic link already exists.');
            return 0;
        }

        // Create the symbolic link
        $this->laravel->make('files')->link($storageAppPublicPath, $publicStoragePath);

        $this->info('The [public/storage] directory has been linked.');
        return 0;
    }
}