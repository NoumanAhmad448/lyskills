<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\Social;
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
        URL::forceScheme('http');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
              
        $social = Social::first();
        if($social){
            $f_is_enable = $social->f_enable;
            if($f_is_enable){
                $f_app_id = $social->f_app_id;
                config(['services.facebook.client_id' => $f_app_id]);
                
                $f_security_key = $social->f_security_key;
                config(['services.facebook.client_secret' => $f_security_key]);
            }

            $g_is_enable = $social->g_enable;
            if($g_is_enable){
                $g_app_id = $social->g_app_id;
                config(['services.google.client_id' => $g_app_id]);
                
                $g_security_key = $social->g_security_key;
                config(['services.google.client_secret' => $g_security_key]);
            }

            $l_is_enable = $social->l_enable;
            if($l_is_enable){
                $l_app_id = $social->l_app_id;
                config(['services.linkedin.client_id' => $l_app_id]);
                
                $l_security_key = $social->l_security_key;
                config(['services.linkedin.client_secret' => $l_security_key]);
            }
        }


        URL::forceScheme('http');


    }
}
