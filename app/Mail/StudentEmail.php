<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public $name;
     public $email ;
     public $course_name;
     public $subject;
     public $body;
     public $ins_name;
    public function __construct($name,$email,$course_name,$subject,$body,$ins_name)
    {
        $this->name=$name;
        $this->email = $email;
        $this->course_name= $course_name;
        $this->subject = $subject;
        $this->body = $body;
        $this->ins_name = $ins_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(getStudentEmail(), 'Student '.$this->name." From Lyskills" )->subject('STUDENT FROM LYSKILLS ' .$this->subject)->markdown('emails.student-email-to-ins');
    }
}
