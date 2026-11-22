<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'short_description','description', 'image', 'page_bg_image', 'banner_image','banner_footer_image',
        'location', 'highlights', 'gallery', 'meta_title', 'meta_keywords',
        'meta_description', 'status'
    ];

    protected $casts = [
        'highlights' => 'array', // Convert JSON to PHP array
        'gallery' => 'array',
    ];

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value, '-');
    }
    public function tours()
    {
        return $this->belongsToMany(Tour::class, 'tour_destinations');
    }
    
    public function categories()
    {
        return $this->belongsToMany(DestinationCategory::class, 'destination_destination_category', 'destination_id', 'category_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($destination) {
            $destination->slug = self::generateUniqueSlug($destination->name);
        });

        static::updating(function ($destination) {
            $destination->slug = self::generateUniqueSlug($destination->name, $destination->id);
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
