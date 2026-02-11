<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Classes\Contracts\TimeFormatterInterface;
use App\Classes\HumanTimeFormatter;
use App\Classes\HourMinuteTimeFormatter;

class TimeFormatterServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(TimeFormatterInterface::class, function () {

            // Switch logic here (config, env, feature flag, etc.)
            if (config('time.format') === 'hhmm') {
                return new HourMinuteTimeFormatter();
            }

            return new HumanTimeFormatter();
        });

        $this->app->singleton('mediaPlayerView', function () {

            if (config('time.video') === 'modern') {
                return 'xuesheng.media-player';
            }

            return 'xuesheng.html5-player';
        });
    }
}
