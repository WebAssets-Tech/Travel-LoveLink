<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'subtitle', 'title', 'buttons','spiti_is_colder','description','contact_us','domestic_trip'];

    protected $casts = [
        'buttons' => 'array', // Convert stored JSON to an array
    ];
}
