<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class EnvFilesConsistencyTest extends TestCase
{
    /** @test */
    public function all_env_files_have_the_same_keys()
    {
        // Define the list of environment files to check
        $envFiles = config("setting.env_files");

        // Get the keys from the base .env file
        $baseEnvPath = base_path(config("setting.base_env"));
        $baseEnvContent = File::get($baseEnvPath);
        $baseKeys = $this->extractKeys($baseEnvContent);

        // Check each environment file
        foreach ($envFiles as $envFile) {
            $envFilePath = base_path($envFile);

            // Skip if the file doesn't exist
            if (!File::exists($envFilePath)) {
                continue;
            }

            // Get the keys from the current environment file
            $envContent = File::get($envFilePath);
            $envKeys = $this->extractKeys($envContent);

            // Compare the keys
            $missingKeys = array_diff($baseKeys, $envKeys);

            // Assert that there are no missing keys
            $this->assertEmpty(
                $missingKeys,
                "The environment file '{$envFile}' is missing the following keys: " . implode(', ', $missingKeys)
            );
        }
    }

    /**
     * Extract keys from environment file content.
     *
     * @param string $content
     * @return array
     */
    private function extractKeys(string $content): array
    {
        $keys = [];

        // Split the content into lines
        $lines = explode("\n", $content);

        foreach ($lines as $line) {
            // Skip empty lines and comments
            if (empty(trim($line)) || strpos(trim($line), '#') === 0) {
                continue;
            }

            // Extract the key (everything before the first '=')
            $key = trim(explode('=', $line)[0]);
            $keys[] = $key;
        }

        return $keys;
    }
}