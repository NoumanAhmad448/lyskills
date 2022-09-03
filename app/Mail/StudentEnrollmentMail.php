<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentEnrollmentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public $name;
     public $course_name;
     public $course_url;
    public function __construct($name,$course_name,$course_url)
    {
        //
        $this->name=$name;
        $this->course_name = $course_name;
        $this->course_url = $course_url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(getCourseEmail())->subject('Congtratulation on Course Enrollment')->markdown('emails.student-enroll');
    }
}
