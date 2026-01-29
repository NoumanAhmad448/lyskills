<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Console\Commands\BaseCron;

class CheckEnvFiles extends BaseCron
{
    protected $signature = 'env:check-consistency';
    protected $description = 'Check all environment files for missing or duplicate keys';

    public function runCron()
    {
        $envFiles = config("setting.env_files") ?? [];
        $baseEnvPath = base_path(config("setting.base_env"));
        $message = "";

        if (!File::exists($baseEnvPath)) {
            $this->error("Base .env file not found at {$baseEnvPath}");
            return;
        }

        $baseContent = File::get($baseEnvPath);
        $baseKeys = $this->extractKeys($baseContent);

        foreach ($envFiles as $envFile) {
            $envFilePath = base_path($envFile);

            if (!File::exists($envFilePath)) {
                $this->warn("Skipping missing file: $envFile");
                continue;
            }

            $envContent = File::get($envFilePath);
            $envKeys = $this->extractKeys($envContent);

            // Check missing keys
            $missingKeys = array_diff($baseKeys, $envKeys);
            if (!empty($missingKeys)) {
                $this->error("File '{$envFile}' is missing keys: " . implode(', ', $missingKeys));
                $message .= "File '{$envFile}' is missing keys: " . implode(', ', $missingKeys);
            } else {
                $this->info("File '{$envFile}' has all required keys.");
            }

            // Check duplicate keys
            $duplicates = $this->checkDuplicateKeysInEnvFile($envFilePath);
            if (is_array($duplicates)) {
                $this->error("File '{$envFile}' has duplicate keys: " . implode(', ', $duplicates));
                $message .= "File '{$envFile}' has duplicate keys: " . implode(', ', $duplicates);
            } else {
                $this->info("No duplicate keys found in '{$envFile}'.");
            }
        }
        return $message;
    }

    private function extractKeys(string $content): array
    {
        $keys = [];
        $lines = explode("\n", $content);

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || str_starts_with($line, '#')) continue;

            $key = trim(explode('=', $line, 2)[0]);
            $keys[] = $key;
        }

        return $keys;
    }

    private function checkDuplicateKeysInEnvFile(string $filePath)
    {
        if (!file_exists($filePath)) return [];

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $keys = [];
        $duplicates = [];

        foreach ($lines as $line) {
            if (strpos($line, '=') === false) continue;

            list($key,) = explode('=', $line, 2);
            $key = trim($key);

            if (isset($keys[$key])) {
                $duplicates[] = $key;
            } else {
                $keys[$key] = true;
            }
        }

        return empty($duplicates) ? null : $duplicates;
    }
}
