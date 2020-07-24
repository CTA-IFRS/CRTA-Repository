<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Slug;

class Product extends Model
{
    use Slug;

    protected $fillable = ['name', 'description', 'body', 'price', 'slug'];

    public function getThumbAttribute()
    {
        return $this->photos->first()->image;
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function photos()
    {
        return $this->hasMany(ProductPhoto::class);
    }
}


//
//namespace App;
//
//use Illuminate\Database\Eloquent\Model;
//use Spatie\Sluggable\HasSlug;
//use Spatie\Sluggable\SlugOptions;
//
//class Product extends Model
//{
//    use HasSlug;
//    protected $fillable = ['name', 'description' , 'body' , 'price' , 'slug'];
//
//    public function getThumbAttribute()
//    {
//        return $this->photos->first()->image;
//    }
//
//    /**
//     * Get the options for generating the slug.
//     */
//    public function getSlugOptions() : SlugOptions
//    {
//        return SlugOptions::create()
//            ->generateSlugsFrom('name')
//            ->saveSlugsTo('slug');
//    }
//
//    public function store()
//    {
//        return $this->belongsTo(Store::class);
//    }
//
//    public function categories()
//    {
//        return $this->belongsToMany(Category::class);
//    }
//    public function photos()
//    {
//        return$this->hasMany(ProductPhoto::class);
//    }
//}
