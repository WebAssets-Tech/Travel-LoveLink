<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TouristGuide extends Model
{
    use HasFactory;

    protected $table = 'tourist_guides';

    protected $fillable = [
        'name',
        'slug',
        'phone',
        'phone2',
        'email',
        'email2',
        'address',
        'language',
        'experience',
        'details_counter',
        'image',
        'page_bg_image',
        'banner_image',
        'bio',
        'location',
        'designation',
        'rating',
        'social_link',
        'status','meta_title', 'meta_keywords', 'meta_description'
    ];

    protected $casts = [
        'details_counter' => 'array',
        'social_link' => 'array',
        'rating' => 'float',
        'status' => 'boolean',
    ];

    /**
     * Get the formatted rating
     */
    public function getFormattedRatingAttribute()
    {
        return number_format($this->rating, 1);
    }

    /**
     * Scope for active guides
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    
    public static function boot()
    {
        parent::boot();

        static::creating(function ($touristguide) {
            $touristguide->slug = self::generateUniqueSlug($touristguide->name);
        });

        static::updating(function ($touristguide) {
            $touristguide->slug = self::generateUniqueSlug($touristguide->name, $touristguide->id);
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
/*

// Access formatted rating
$guide = TouristGuide::find(1);
echo $guide->formatted_rating; // Output: 4.5


*/