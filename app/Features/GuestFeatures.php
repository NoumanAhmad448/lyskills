<?php

namespace App\Features;

class GuestFeatures
{
    public static function enableVerifyEmail()
    {
        return config("setting.enable_verify_email");
    }
}
