<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssDescription extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function ass()
    {
        return $this->belongsTo(Assignment::class);
    }

}
