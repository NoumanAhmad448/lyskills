<?php

namespace App\Routes;

class GuestRoutes
{

    public static function verifyEmail()
    {
        return config("routes.verify_emails");
    }

    public static function verifyEmailHash()
    {
        return config("routes.verify_emails_hash");
    }
}
