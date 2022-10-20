<?php

namespace App\Http\Controllers;

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
        Artisan::call("key:generate");
        $this->clearCache();
        Artisan::call("migrate");
    }
}
