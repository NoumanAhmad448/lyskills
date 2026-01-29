<?php

namespace App\Console\Commands;

use App\Console\Commands\BaseCron;

class CheckAppDebug extends BaseCron
{
    protected $signature = 'app:check-debug';
    protected $description = 'Check if app.debug or app.js_debug is enabled';

    /**
     * Run the cron logic.
     *
     * @return string|null
     */
    public function runCron()
    {
        $errors = "";

        // Check app.debug
        if (config('app.debug') === true) {
            $errors .= 'Error: app.debug is set to true.';
        }

        // Check app.js_debug
        if (config('app.js_debug') === true) {
            $errors .= 'Error: app.js_debug is set to true.';
        }

        // Return error message if any
        if (!empty($errors)) {
            return $errors;
        }

    }
}
