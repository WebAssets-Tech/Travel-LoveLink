<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Setting extends Model
{
    use HasFactory;

    protected $table = 'setting';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    
     protected $fillable = [
        'name',
        'page_bg_image',
        'breadcrumb_bg_type',
        'breadcrumb_bg_color',
        'meta_image',
        'footer_script',
        'youtube_vid_link',
        'header_script',
        'email',
        'email1',
        'phone',
        'phone1',
        'address',
        'header_logo',
        'footer_logo',
        'footer_about',
        'footer_copyright',
        'favicon',
        'app_url',
        'map_link',
        'social_link',
        'about_images',
        'about_subtitle',
        'about_title',
        'about_content',
        'about_ot_content',
        'home_counter',
        'preloader',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'status',
    ];

    protected $casts = [
        'social_link' => 'array',
        'page_bg_image' => 'array',
        'about_images' => 'array',
        'about_ot_content' => 'array',
        'home_counter' => 'array',
        'preloader' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('global_layout_shared_data');
        });
        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('global_layout_shared_data');
        });
    }
}
