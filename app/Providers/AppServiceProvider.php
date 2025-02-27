<?php

namespace App\Providers;

use App\Models\ConfigSetting;
use App\Models\Social;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
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
use Spatie\SecurityAdvisoriesHealthCheck\SecurityAdvisoriesCheck;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if(trim(config('app.env')) === "developement"){
            URL::forceScheme('http');
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            DB::connection()->getPdo();  // Try to connect to the database
        if(Schema::hasTable('socials')){
        $social = Social::first();
        if($social){
            $social->setSocialMedia();
        }
        }

        if(Schema::hasTable('config_settings')){
            $settings = ConfigSetting::all();
            if($settings){
                foreach ($settings as $setting){
                    config(["setting.".$setting->key => false]);
                }
            }
        }
        if(trim(config('app.env')) === "developement"){
            URL::forceScheme('http');
        }
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

        if (in_array(config('app.env'), ['production', 'prod'])) {
            $checks[] = Js_Debug::new();
            // $checks[] = CpuLoadCheck::new()->failWhenLoadIsHigherInTheLast15Minutes(2.0);
            $checks[] = EnvironmentCheck::new();
            $checks[] = UsedDiskSpaceCheck::new();
            $checks[] = PingCheck::new()->url(config('app.url'))->retryTimes(config('setting.retry_time'));
        }
        Health::checks($checks);
    } catch (\Exception $e) {
        Log::error('Database connection failed: ' . $e->getMessage());
    }
    }
}
