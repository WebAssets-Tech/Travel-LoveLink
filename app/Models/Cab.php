<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cab extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'short_description','description', 'image', 'page_bg_image', 'banner_image','cab_type',
        'seating_capacity', 'price', 'meta_title', 'meta_keywords',
        'meta_description', 'status','highlights','footer_gallery',
        'order' // Display Order field
    ];
 

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value, '-');
    } 
    public static function boot()
    {
        parent::boot();

        static::creating(function ($cab) {
            $cab->slug = self::generateUniqueSlug($cab->name);
        });

        static::updating(function ($cab) {
            $cab->slug = self::generateUniqueSlug($cab->name, $cab->id);
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
    
    public function getFormattedPriceAttribute()
    {
        return $this->price ? '₹' . number_format($this->price, 2) : 'Price on Request';
    }

    /**
     * Scope to order cabs by sequence order ascending
     */
    public function scopeOrdered($query)
    {
        return $query->orderByRaw('CASE WHEN `order` IS NULL THEN 1 ELSE 0 END, `order` ASC, id DESC');
    }

    protected $casts = [
        'highlights' => 'array',
    ];
}
