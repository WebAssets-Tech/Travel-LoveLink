<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelBestie extends Model
{
    use HasFactory;

    protected $table="travel_bestie";

    protected $fillable = ['title', 'image', 'status', 'description'];
}
