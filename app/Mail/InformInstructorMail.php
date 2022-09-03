<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InformInstructorMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public $u_name;
     public $course_name;
     public $course_link;
     public $ur_name;

    public function __construct($u_name,$course_name,$course_link,$ur_name)
    {
        $this->u_name = $u_name;
        $this->course_name = $course_name;
        $this->course_link = $course_link;
        $this->ur_name = $ur_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(getCourseEmail(),config('app.name'))->subject("Student ".$this->u_name ." has bought the ".$this->course_name. " course from ". config('app.name'))->markdown('emails.inform-instructor');
    }
}
