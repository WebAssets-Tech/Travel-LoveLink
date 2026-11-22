<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'price',
        'rating',
        'discount_price',
        'duration',
        'image',
        'banner_image',
        'page_bg_image',
        'highlights_content',
        'highlights',
        'basic_content',
        'basic',
        'include_exclude_content',
        'include_exclude',
        'itinerary',
        'gallery',
        'footer_gallery',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'status',
        'type',
        'venue_date',
        'domestic_trip','state_id',
        'booking','cancellation'
    ];

    protected $casts = [
        'highlights' => 'array',
        'basic' => 'array',
        'include_exclude' => 'array',
        'itinerary' => 'array',
        'gallery' => 'array',
        'footer_gallery' => 'array'
    ];

    
    public function scopeVenue($query)
    {
        return $query->where('type', '0');
    }
    public function scopeFvnue($query)
    {
        return $query->where('type', '2');
    }

    public function scopeNonVenue($query)
    {
        return $query->where('type', '1');
    }
    // Relationship with categories
    public function categories()
    {
        return $this->belongsToMany(TourCategory::class, 'tour_tour_category', 'tour_id', 'category_id');
    }

    // Relationship with destinations
    public function destinations()
    {
        return $this->belongsToMany(Destination::class, 'tour_destinations');
    }

    // Relationship with activities
    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'tour_activities');
    }
    
    public function getFormattedPriceAttribute()
    {
        return $this->price ? '₹' . number_format($this->price, 2) : 'Price on Request';
    }
    public static function boot()
    {
        parent::boot();

        static::creating(function ($tour) {
            $tour->slug = self::generateUniqueSlug($tour->title);
        });

        static::updating(function ($tour) {
            $tour->slug = self::generateUniqueSlug($tour->title, $tour->id);
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
    
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    protected static function booted(): void
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('homepage_curated_data');
        });
        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('homepage_curated_data');
        });
    }
}
