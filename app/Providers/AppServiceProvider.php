<?php

namespace App\Providers;

use App\Models\ConfigSetting;
use App\Models\Social;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
    }
}
