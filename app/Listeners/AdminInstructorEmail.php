<?php

namespace App\Listeners;

use App\Events\CourseStatusEmail;
use App\Mail\InstructorCourseStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class AdminInstructorEmail implements ShouldQueue
{
    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    


    
    /**
     * Handle the event.
     *
     * @param  CourseStatusEmail  $event
     * @return void
     */
    public function handle(CourseStatusEmail $event)
    {
        $course_name = $event->course->course_title;
        $author = $event->course->user->name; 
        $status = $event->course->status;
        $email = $event->course->user->email; 
        Mail::to($email)
            ->send(new InstructorCourseStatus($course_name,$author,$status));        
        
    }
}
