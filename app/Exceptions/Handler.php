<?php

namespace App\Exceptions;

use App\Notifications\SlackErrorNotification;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Notification;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        // Send Slack notification only in production
        if (app()->environment('production') && $this->isHttp500Error($exception)) {
            Notification::route("slack", config("health.notifications.slack.webhook_url"))->notify(new SlackErrorNotification($exception));
        }

        parent::report($exception);
    }

    /**
     * Check if the exception is a 500 error.
     *
     * @param  \Exception  $exception
     * @return bool
     */
    protected function isHttp500Error(Throwable $exception)
    {
        return method_exists($exception, 'getStatusCode') && $exception instanceof HttpException && $exception?->getStatusCode() === 500;
    }
}
