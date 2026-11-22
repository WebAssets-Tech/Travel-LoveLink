<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'page_bg_image',
        'banner_image',
        'banner_footer_image',
        'features',
        'price',
        'highlights',
        'gallery',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'status',
    ];

    // Automatically cast JSON fields as arrays
    protected $casts = [
        'features' => 'array',
        'highlights' => 'array',
        'gallery' => 'array',
    ];
    
    public function getFormattedPriceAttribute()
    {
        return $this->price ? '₹' . number_format($this->price, 2) : 'Price on Request';
    }
    public static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            $service->slug = self::generateUniqueSlug($service->title);
        });

        static::updating(function ($service) {
            $service->slug = self::generateUniqueSlug($service->title, $service->id);
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
