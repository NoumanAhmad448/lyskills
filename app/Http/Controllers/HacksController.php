<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConfigSetting;

class HacksController extends Controller
{
    public function changeConfig(Request $req)
    {
        $req_name = $req->name;
        $req_value = $req->value == 1 ? true: false;
        $op = "INSERT";

        if(empty($req_value) && ConfigSetting::where('key', $req_name)->count() < 1){
            $setting = new ConfigSetting;
            $setting->key= $req_name;
            $setting->value = $req_value;
            $setting->save();
        }

        if(!empty($req_value)){
            ConfigSetting::where('key',$req_name)->delete();
            $op = "DELETE";
        }
        return "operation $op has been successfully done";
    }
}
