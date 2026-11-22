<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'link',
        'parent_id',
        'order',
        'type',
        'status',
    ];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }
    
    public function childrenRecursive()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order')->with('childrenRecursive');
    }

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

