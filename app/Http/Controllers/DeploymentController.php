<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Artisan;

class DeploymentController extends Controller
{
    public function clearCache()
    {
        Artisan::call("config:cache");
        Artisan::call("route:cache");
        Artisan::call("view:cache");
        dd("config, view, route are cached successfully");
    }
    public function liveDeployment()
    {
        try{
            Artisan::call("key:generate");
            $this->clearCache();
            Artisan::call("migrate");
        }catch(Exception $e){
            if($_REQUEST[config("setting.show_errors_label")] == 1){
                dd($e->getMessage());
            }
        }
    }
}
