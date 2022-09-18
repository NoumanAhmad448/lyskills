<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
    use HasFactory;
    protected $fillable = ['lecture_id','description'];

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }
}
