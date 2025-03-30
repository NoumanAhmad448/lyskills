<?php

namespace App\Routes;

class EmailRoutes
{
    public const EN = '/email/verification-notification';

    public static function emailNotification()
    {
        return config("routes.en") ?? static::EN;
    }
}
