<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Hotel extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'name',
        'slug',
        'category',
        'type',
        'star_rating',
        'location',
        'short_description',
        'description',
        'image',
        'banner_image',
        'page_bg_image',
        'banner_footer_image',
        'highlights',
        'gallery',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'status',
    ];

    // Automatically cast JSON fields to arrays
    protected $casts = [
        'highlights' => 'array',
        'gallery' => 'array',
        'status' => 'boolean',
    ];
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value, '-');
    } 
    public static function boot()
    {
        parent::boot();

        static::creating(function ($hotel) {
            $hotel->slug = self::generateUniqueSlug($hotel->name);
        });

        static::updating(function ($hotel) {
            $hotel->slug = self::generateUniqueSlug($hotel->name, $hotel->id);
        });

        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('homepage_curated_data');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('homepage_curated_data');
        });
    }

    // Function to Generate Unique Slug
    public static function generateUniqueSlug($title, $id = null)
    {
        $slug = Str::slug($title);
        $count = 0;
        
        // Check if slug already exists
        while (self::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $count++;
            $slug = Str::slug($title) . '-' . $count;
        }

        return $slug;
    }
}
