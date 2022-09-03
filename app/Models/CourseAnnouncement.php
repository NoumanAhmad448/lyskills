<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAnnouncement extends Model
{
    use HasFactory;
    protected $fillable = ['subject','course_id','body'];


}
