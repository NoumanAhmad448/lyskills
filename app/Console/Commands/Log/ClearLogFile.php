<?php

namespace App\Console\Commands\Log;

use App\Models\CronJobs;
use App\Classes\LyskillsCarbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearLogFile extends Command {
    // Command name
    protected $signature = "log:clear {duration=7}
                {ext='*.log'}
    ";

    // Description
    protected $description = 'Clear Laravel log';

    public function handle() {

        $cron_job = CronJobs::firstOrCreate(
            [
                config('table.name') => $this->signature
            ],
            [
            config('table.name') => $this->signature,
            config('table.status') => config('constants.idle'),
            config('table.w_name') => config('app.url'),
            config('table.starts_at') => LyskillsCarbon::now()
        ]);

        try {
            $path = "logs";
            $undeletedFiles = [];

            debug_logs('duration => '.$this->argument('duration'));
            debug_logs('ext => '.$this->argument('ext'));
            $rootPath = storage_path($path); // Change this if you want to delete from another path

            // OS Detection
            $os = PHP_OS_FAMILY;
            $this->info("Operating System: $os");

            // Deletion Process
            $this->deleteFilesRecursively($rootPath, $undeletedFiles,$this->argument('duration'),$this->argument('ext'));

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
            $this->info(__('messages.cnsl_msg', ['msg' => 'Logs have been cleared']));
            $cron_job->update([
                config('table.status') => config('constants.successed'),
                config('table.ends_at') => LyskillsCarbon::now(),
            ]);
        } catch (Exception $e) {
            $cron_job->update([
                config('table.status') => config('constants.error'),
                config('table.message') => $e->getMessage(),
                config('table.ends_at') => LyskillsCarbon::now(),
            ]);
        }
    }
    private function deleteFilesRecursively($path, &$undeletedFiles,$days,$ext)
    {
        if (!File::exists($path)) {
            debug_logs($path . " does not exist");
            return;
        }
        $days = (int)$days;
        $items = File::allFiles($path);

        foreach ($items as $item) {
            try {
                $lastModified = LyskillsCarbon::createFromTimestamp(File::lastModified($item));
                if ($lastModified->lt(LyskillsCarbon::now()->subDays($days))) {
                    File::delete($item);
                    debug_logs("Deleted file: $item?->getPathname()");
                }
            } catch (\Exception $e) {
                $undeletedFiles[] = $item->getPathname();
                debug_logs($e->getMessage());
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
