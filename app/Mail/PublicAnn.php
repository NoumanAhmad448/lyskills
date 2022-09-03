<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PublicAnn extends Mailable  implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public $subject;
     public $body;
     public $name;
    public function __construct($subject,$body,$name)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(getAdminEmail())->subject($this->subject)->
            markdown('emails.public-ann',[                
                'body' => $this->body,
                'name' => $this->name
            ]);
    }
}
