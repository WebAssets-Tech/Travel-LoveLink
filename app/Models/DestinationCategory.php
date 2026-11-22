<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DestinationCategory  extends Model {

    use HasFactory;
    protected $table = 'destination_category';
    protected $fillable = [
        'name', 'slug', 'description', 'image', 'page_bg_image','banner_image','banner_footer_image','gallery',
        'meta_title', 'meta_keywords', 'meta_description',
        'parent_id', 'status', 'odby'
    ];
    protected $casts = [ 
        'gallery' => 'array',
    ];

    // Parent Category Relationship
    public function parent() {
        return $this->belongsTo(DestinationCategory::class, 'parent_id');
    }

    // Subcategories Relationship
    public function subcategories() {
        return $this->hasMany(DestinationCategory::class, 'parent_id');
    }
     
    public function childrenRecursive()
    {
        return $this->hasMany(DestinationCategory::class, 'parent_id')->with('childrenRecursive');
    }
    public function destinations()
    {
        return $this->belongsToMany(Destination::class, 'destination_destination_category', 'category_id', 'destination_id');
    }

    
    public static function boot()
    {
        parent::boot();

        static::creating(function ($destinationcategory) {
            $destinationcategory->slug = self::generateUniqueSlug($destinationcategory->name);
        });

        static::updating(function ($destinationcategory) {
            $destinationcategory->slug = self::generateUniqueSlug($destinationcategory->name, $destinationcategory->id);
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
