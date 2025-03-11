<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;
use Throwable;

class SlackErrorNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public ?Throwable $exception = null) {}


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toSlack($notifiable)
    {
        // Check if $this->exception is valid
        if (!$this->exception instanceof Throwable) {
            return (new SlackMessage)
                ->error()
                ->content('🚨 An unknown error occurred in production. 🚨');
        }

        return (new SlackMessage)
            ->error()
            ->content('🚨 *500 Error Occurred in Production* 🚨')
            ->attachment(function ($attachment) {
                $attachment
                    ->title('Error Details')
                    ->fields([
                        'Message' => $this?->exception->getMessage(),
                        'File' => $this?->exception->getFile(),
                        'Line' => $this?->exception->getLine(),
                        'Environment' => config('app.env'),
                    ]);
            });
    }
}
