<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }

    public function ass_desc()
    {
        return $this->hasOne(AssDescription::class,'ass_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class,'course_no');
    }
}
