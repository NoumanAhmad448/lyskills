<?php

namespace App\Spatie;

use Spatie\Health\Checks\Check;
use Spatie\Health\Checks\Result;

class SlackKeys extends Check {
    public function run(): Result {
        $result = Result::make();
        $result->shortSummary('Slack Keys enabled/disabled');
        if (config('health.notifications.slack.webhook_url')
            && config('health.notifications.slack.channel')
            && config('health.notifications.slack.username')
        ) {
            return $result->ok();
        } else {
            return $result->failed();
        }
    }
}
