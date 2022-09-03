<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Course extends Model
{
    use HasFactory;
    use HasSlug;

    protected $guarded = [];


    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        
        return SlugOptions::create()
            ->generateSlugsFrom('course_title')
            ->saveSlugsTo('slug')
            ;            
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }


    public function lecture(){
        return $this->hasOne(Lecture::class);
    }

    public function course_image()
    {
        return $this->hasOne(CourseImage::class);
    }
    
    public function course_vid()
    {
        return $this->hasOne(CourseVideo::class);
    }

    public function price()
    {
        return $this->hasOne(Pricing::class);
    }

    public function promotion()
    {
        return $this->hasMany(Promotion::class);

    }
    public function sayonara()
    {
        return $this->hasOne(Sayonara::class);

    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class,'course_no');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class,'course_no');
    }

    public function courseEnrollment()
    {
        return $this->hasMany(CourseEnrollment::class,'course_id');
    }

    public function wishlist()
    {
        return $this->hasMany(WishList::class,'c_id','id');
    }

    public function lang()
    {
        return $this->hasOne(LanguageModal::class, 'id', 'lang_id' );
    }

}
