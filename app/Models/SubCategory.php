<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'value', 'category_id'];

    /**
     * Get the category that owns the sub-category.
     */
    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
}
