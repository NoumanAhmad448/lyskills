<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    protected $guarded  = [];

   public function lecture()
   {
    return $this->belongsTo(Lecture::class);

   }

   public function quizzes()
   {
    return $this->hasMany(QuizQuestionAns::class);

   }




}
