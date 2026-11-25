<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class State extends Model
{
    protected $fillable = [
        'country_id',
        'name',
        'code',
        'short_destinations',
        'status',
        'image',
        'page_bg_image',
        'banner_image',
        'banner_footer_image',
        'gallery',
        'slug',
        'order',
    ];

    public function getShortDestinationsListAttribute(): array
    {
        if (empty($this->short_destinations)) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $this->short_destinations))));
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function getGalleryArrayAttribute()
    {
        return json_decode($this->gallery, true) ?? [];
    }

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($state) {
            $state->slug = self::generateUniqueSlug($state->name);
        });

        static::updating(function ($state) {
            $state->slug = self::generateUniqueSlug($state->name, $state->id);
        });
    }

    public static function generateUniqueSlug($name, $id = null)
    {
        $slug = Str::slug($name);
        $count = 0;

        while (self::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $count++;
            $slug = Str::slug($name) . '-' . $count;
        }

        return $slug;
    }
}
