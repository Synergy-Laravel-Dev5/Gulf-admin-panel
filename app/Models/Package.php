<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'title',
        'subtitle',
        'makkah_hotel_name',
        'makkah_hotel_distance',
        'madinah_hotel_name',
        'madinah_hotel_distance',
        'travel_date_from',
        'travel_date_to',
        'price_sharing',
        'price_triple',
        'price_double',
        'features',
        'requirements',
        'description',
        'image',
        'status',
    ];

    public function bookings()
    {
        return $this->hasMany(PackageBooking::class);
    }
}