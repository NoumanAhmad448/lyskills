<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentSubmition extends Model
{
    use HasFactory;

    protected $table = "assignments_submission";
    public $timestamps = false;
    protected $guarded = [];

    public function student(){
        return $this->belongsTo(User::class, "id", "student_id");
    }
}
