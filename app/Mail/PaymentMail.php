<?php

namespace App\Mail;

use App\Classes\LyskillsCarbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $name;
    public $email;
    public function __construct($name,$email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $month = LyskillsCarbon::currentMonth() -1;
        $year = LyskillsCarbon::currentYear();
        return $this->from(getAdminEmail())->subject("Month ".$month. " Year". $year. " Payment from Lyskills")->markdown('emails.monthly-payment');
    }
}
