<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Spatie\GoogleCaptcha;
use App\Spatie\Js_Debug;
use App\Spatie\SlackKeys;
use Spatie\CpuLoadHealthCheck\CpuLoadCheck;
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DatabaseConnectionCountCheck;
use Spatie\Health\Checks\Checks\DatabaseSizeCheck;
use Spatie\Health\Checks\Checks\DatabaseTableSizeCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\PingCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Facades\Health;

class HealthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $checks = [
            DatabaseCheck::new(),
            CacheCheck::new(),
            OptimizedAppCheck::new()
                ->checkConfig()
                ->checkRoutes(),
            DatabaseConnectionCountCheck::new()
                ->failWhenMoreConnectionsThan(100),
            DatabaseTableSizeCheck::new()
                ->table(config('table.users'), maxSizeInMb: config('setting.max_tble_size')),
            DebugModeCheck::new(),
            GoogleCaptcha::new(),
            DatabaseSizeCheck::new(),
            SlackKeys::new(),
        ];

        if (in_array(config('app.env'), [config("app.live_env"), 'prod'])) {
            $checks[] = Js_Debug::new();
            // $checks[] = CpuLoadCheck::new()->failWhenLoadIsHigherInTheLast15Minutes(2.0);
            $checks[] = EnvironmentCheck::new();
            $checks[] = UsedDiskSpaceCheck::new();
            $checks[] = PingCheck::new()->url(config('app.url'))->retryTimes(config('setting.retry_time'));
        }
        Health::checks($checks);
    }
}
