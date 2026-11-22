<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompressedImage extends Model
{
    use HasFactory;

    protected $fillable = ['directory', 'image_name'];
}
