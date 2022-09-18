<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */


     public $name;
     public $email;
     public $mobile;
     public $country;
     public $subject;
     public $body;

    public function __construct($name,$email,$mobile,$country,$subject,$body)
    {
        $this->name = $name;
        $this->email = $email;
        $this->mobile = $mobile;
        $this->country = $country;
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Contact Us Form ' .$this->subject)->markdown('email.contact-us-email');
    }
}
