<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DeleteAllFiles extends Command
{
    protected $signature = 'files:delete-all {path? : The path to delete files from}';
    protected $description = 'Delete all files and folders recursively, skipping undeletable ones and logging them';

    public function handle()
    {
        $path = $this->argument('path') ?? base_path();

        $this->info("Deleting files and directories from: $path");

        $rootPath = base_path($path); // Change this if you want to delete from another path
        $undeletedFiles = [];

        // OS Detection
        $os = PHP_OS_FAMILY;
        $this->info("Operating System: $os");

        // Deletion Process
        $this->deleteFilesRecursively($rootPath, $undeletedFiles);

        // Display Results
        if (!empty($undeletedFiles)) {
            $this->warn("\nFiles that couldn't be deleted:");
            foreach ($undeletedFiles as $file) {
                $this->line("- " . $file);
            }
            $this->warn("\nTotal undeleted files: " . count($undeletedFiles));
        } else {
            $this->info("\nAll files and folders deleted successfully!");
        }
    }

    private function deleteFilesRecursively($path, &$undeletedFiles)
    {
        if (!File::exists($path)) {
            debug_logs($path . " does not exist");
            return;
        }

        $items = File::allFiles($path);
        foreach ($items as $item) {
            try {
                File::delete($item);
                debug_logs("Deleted file: $item?->getPathname()");
            } catch (\Exception $e) {
                $undeletedFiles[] = $item->getPathname();
            }
        }

        $directories = File::directories($path);
        foreach ($directories as $directory) {
            try {
                File::deleteDirectory($directory);
                debug_logs("Deleted directory: $directory");
            } catch (\Exception $e) {
                $undeletedFiles[] = $directory;
            }
        }
    }
}
