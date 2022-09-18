<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function media(){
        return $this->hasOne(Media::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function description(){
        return $this->hasOne(Description::class);
    }

    public function res_vid()
    {
        return $this->hasOne(ResVideo::class);
    }

    public function article()
    {
        return $this->hasOne(Article::class);
    }

    public function ex_res()
    {
        return $this->hasOne(ExRes::class);
    }

    public function other_file()
    {
        return $this->hasOne(OtherFiles::class);
    }

    public function assign(){
        return $this->hasMany(Assignment::class);
    }


    public function quizzs()
    {
        return $this->hasMany(Quiz::class);
    }
}
