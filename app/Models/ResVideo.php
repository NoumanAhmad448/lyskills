<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResVideo extends Model
{
    use HasFactory;
    protected $fillable = ['lecture_id','lec_path','f_name','f_mimetype'];

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }


}
