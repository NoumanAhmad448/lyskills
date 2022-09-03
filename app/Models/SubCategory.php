<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $fillable = ['categories_id','name','value'];


    public function category()
    {
        return $this->belongsTo(Categories::class, 'categories_id');
    }
}
