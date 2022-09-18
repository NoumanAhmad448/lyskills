<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InstructorCourseStatus extends Mailable
{
    use Queueable, SerializesModels;
    public $course_name;
    public $author;
    public $status;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($course_name,$author,$status)
    {
        $this->course_name = $course_name;
        $this->author = $author;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->course_name.'-'.$this->status.'-'.$this->author)->markdown('emails.courses.course-status')
            ->with([
                'name' => $this->author,
                'course_name' => $this->course_name,
                'course_status' => $this->status,
            ])
        ;
    }
}
