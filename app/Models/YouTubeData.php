<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YouTubeData extends Model
{
    use HasFactory;

    protected $table="you_tube_data";

    protected $fillable = ['title', 'youtube_link', 'image', 'status', 'description'];
}
