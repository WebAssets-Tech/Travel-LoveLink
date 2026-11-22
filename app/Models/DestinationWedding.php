<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DestinationWedding extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'short_description','description',  'category', 'image', 'page_bg_image', 'banner_image',
        'location', 'highlights', 'gallery', 'meta_title', 'meta_keywords',
        'meta_description', 'status', 'type'
    ];

    protected $casts = [
        'highlights' => 'array', // Convert JSON to PHP array
        'gallery' => 'array',
    ];

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value, '-');
    } 
    
    public function scopeVendor($query)
    {
        return $query->where('type', '0');
    }

    public function scopeWeddings($query)
    {
        return $query->where('type', '1');
    }
    public static function boot()
    {
        parent::boot();

        static::creating(function ($wedding) {
            $wedding->slug = self::generateUniqueSlug($wedding->title);
        });

        static::updating(function ($wedding) {
            $wedding->slug = self::generateUniqueSlug($wedding->title, $wedding->id);
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
