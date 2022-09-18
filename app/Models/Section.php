<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $fillable = ['course_id','section_no','section_title'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}

