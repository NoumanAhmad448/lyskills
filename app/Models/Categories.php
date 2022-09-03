<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $fillable = ['name','value'];

    /**
     * Get the subCategories for the main category.
     */
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
