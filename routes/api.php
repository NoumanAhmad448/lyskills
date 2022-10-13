<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get("/clear-cache", function(){
    try{
        Artisan::call("config:cache");
        dd(__("messages.config_success"));
    }catch(Exception $d){
        dd($d->getMessage());
    }
});