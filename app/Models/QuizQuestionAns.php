<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestionAns extends Model
{
    use HasFactory;

    protected $guarded  = [];


    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
