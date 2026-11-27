<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Houseboat extends Model
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

    protected $casts = [
        'highlights' => 'array',
        'gallery' => 'array',
        'status' => 'boolean',
    ];

    public function setSlugAttribute($value): void
    {
        $this->attributes['slug'] = Str::slug($value, '-');
    }

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($houseboat) {
            $houseboat->slug = self::generateUniqueSlug($houseboat->name);
        });

        static::updating(function ($houseboat) {
            $houseboat->slug = self::generateUniqueSlug($houseboat->name, $houseboat->id);
        });

        static::saved(function () {
            Cache::forget('homepage_curated_data');
        });

        static::deleted(function () {
            Cache::forget('homepage_curated_data');
        });
    }

    public static function generateUniqueSlug(string $title, ?int $id = null): string
    {
        $slug = Str::slug($title);
        $count = 0;

        while (self::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $count++;
            $slug = Str::slug($title) . '-' . $count;
        }

        return $slug;
    }
}
