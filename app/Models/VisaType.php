<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisaType extends Model
{
    use HasFactory;

    protected $fillable = [
        'visa_country_id',
        'visa_name',
        'b2b_rate',
        'visa_fee',
        'processing_time',
        'requirements',
        'notes',
        'is_active'
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'requirements' => 'array',
    ];

    public function country()
    {
        return $this->belongsTo(VisaCountry::class, 'visa_country_id');
    }
}
