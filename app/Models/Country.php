<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'code',
        'status',
        'image',
        'page_bg_image',
        'banner_image',
        'banner_footer_image',
        'gallery',
    ];

    public function states()
    {
        return $this->hasMany(State::class);
    }

    public function getGalleryArrayAttribute()
    {
        return json_decode($this->gallery, true) ?? [];
    }
}