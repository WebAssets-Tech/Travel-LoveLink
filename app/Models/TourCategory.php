<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TourCategory  extends Model {

    use HasFactory;
    protected $table = 'tour_category';
    protected $fillable = [
        'name', 'slug', 'description', 'image', 'page_bg_image','banner_image','banner_footer_image','gallery',
        'meta_title', 'meta_keywords', 'meta_description',
        'parent_id', 'status', 'odby','type'
    ];
    protected $casts = [ 
        'gallery' => 'array',
    ];

    // Parent Category Relationship
    public function parent() {
        return $this->belongsTo(TourCategory::class, 'parent_id');
    }

    // Subcategories Relationship
    public function subcategories() {
        return $this->hasMany(TourCategory::class, 'parent_id');
    }
     
    public function childrenRecursive()
    {
        return $this->hasMany(TourCategory::class, 'parent_id')->with('childrenRecursive');
    }
    public function tours()
    {
        return $this->belongsToMany(Tour::class, 'tour_tour_category', 'category_id', 'tour_id');
    }

    
    public static function boot()
    {
        parent::boot();

        static::creating(function ($tourcategory) {
            $tourcategory->slug = self::generateUniqueSlug($tourcategory->name);
        });

        static::updating(function ($tourcategory) {
            $tourcategory->slug = self::generateUniqueSlug($tourcategory->name, $tourcategory->id);
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
