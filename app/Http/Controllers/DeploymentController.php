<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Artisan;

class DeploymentController extends Controller
{
    public function clearCache()
    {
        Artisan::call("config:cache");
        Artisan::call("route:cache");
        Artisan::call("view:cache");
        dump("config, view, route are cached successfully");
    }
    public function liveDeployment(Request $req)
    {
        try{
            Artisan::call("key:generate");
            $this->clearCache();
            Artisan::call("migrate");
        }catch(Exception $th){
            if(config("app.debug")){
                dd($th->getMessage());
            }else{
                echo config("setting.err_msg");
            }
        }
    }
}
