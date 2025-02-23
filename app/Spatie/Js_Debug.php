<?php

namespace App\Spatie;

use Spatie\Health\Checks\Check;
use Spatie\Health\Checks\Result;

class Js_Debug extends Check {
    public function run(): Result {
        $result = Result::make();
        $result->shortSummary('JS Debugging enabled/disabled');
        if (config('app.js_debug')) {
            return $result->failed();
        } else {
            return $result->ok();

        }
    }
}
