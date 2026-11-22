<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'days',
        'map_link',
        'slug',
        'description',
        'image',
        'banner_image',
        'page_bg_image',
        'price',
        'highlights',
        'important_info',
        'include_exclude',
        'gallery',
        'rating',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'status',
    ];

    protected $casts = [
        'highlights' => 'array',
        'important_info' => 'array',
        'include_exclude' => 'array',
        'gallery' => 'array',
    ];

    /**
     * Scope to filter only active activities.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Get the full URL of the image.
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('default-image.jpg');
    }

    /**
     * Get the formatted price with currency symbol.
     */
    public function getFormattedPriceAttribute()
    {
        return $this->price ? '₹' . number_format($this->price, 2) : 'Price on Request';
    }

    public function tours()
    {
        return $this->belongsToMany(Tour::class, 'tour_activities');
    }

    
    public static function boot()
    {
        parent::boot();

        static::creating(function ($activity) {
            $activity->slug = self::generateUniqueSlug($activity->name);
        });

        static::updating(function ($activity) {
            $activity->slug = self::generateUniqueSlug($activity->title, $activity->id);
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
