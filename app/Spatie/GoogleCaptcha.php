<?php

namespace App\Spatie;

use Spatie\Health\Checks\Check;
use Spatie\Health\Checks\Result;

class GoogleCaptcha extends Check
{
    public function run(): Result
    {
        $result = Result::make();
        $result->shortSummary('Google Captcha key/secret enabled/disabled');

        if (config('app.google_captcha_key') && config('app.google_captcha_secret')) {
            $result->notificationMessage("Enabled");
            return $result->ok();
        } else {
            $result->notificationMessage("Disbled");
            return $result->failed();
        }
    }
}
