<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'slug',
        'content', 
        'page_bg_image',
        'banner_image', 
        'meta_title',
        'meta_keywords',
        'meta_description',
        'status',
    ];

    protected $casts = [ 
        'status' => 'boolean', 
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    
    public static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            $page->slug = self::generateUniqueSlug($page->title);
        });

        static::updating(function ($page) {
            $page->slug = self::generateUniqueSlug($page->title, $page->id);
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
