<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderIcon extends Model
{
    use HasFactory;

    protected $table="slider_icons";

    protected $fillable = ['title', 'image', 'status', 'description', 'link'];
}
