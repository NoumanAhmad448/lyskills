<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function setSocialMedia(){
        $f_is_enable = $this->f_enable;
        if($f_is_enable){
            $f_app_id = $this->f_app_id;
            config(['services.facebook.client_id' => $f_app_id]);

            $f_security_key = $this->f_security_key;
            config(['services.facebook.client_secret' => $f_security_key]);
        }

        $g_is_enable = $this->g_enable;
        if($g_is_enable){
            $g_app_id = $this->g_app_id;
            config(['services.google.client_id' => $g_app_id]);
            $g_security_key = $this->g_security_key;
            config(['services.google.client_secret' => $g_security_key]);
        }

        $l_is_enable = $this->l_enable;
        if($l_is_enable){
            $l_app_id = $this->l_app_id;
            config(['services.linkedin.client_id' => $l_app_id]);

            $l_security_key = $this->l_security_key;
            config(['services.linkedin.client_secret' => $l_security_key]);
        }
    }

}
