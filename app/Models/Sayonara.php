<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sayonara extends Model
{
    use HasFactory;
    protected $fillable  = ['welcome_msg','course_id','congo_msg'];

}
