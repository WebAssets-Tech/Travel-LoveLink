<?php
// app/Models/GlobalBooking.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalBooking extends Model
{
    protected $fillable = [
        'booking_type', 'pickup_location', 'drop_location', 'hotel_location',
        'checkin_date', 'checkout_date', 'adults', 'kids', 'rooms',
        'pickup_time', 'status',
    ];

    protected $casts = [
        'checkin_date' => 'date',
        'checkout_date' => 'date',
    ];
}