<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = ['question', 'answer', 'order', 'status'];

    // Scope for active FAQs
    public function scopeActive($query)
    {
        return $query->where('status', 1)->orderBy('order', 'asc');
    }
}
