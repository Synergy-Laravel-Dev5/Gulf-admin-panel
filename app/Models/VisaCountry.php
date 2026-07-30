<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisaCountry extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'country_name',
        'country_code',
        'flag',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = ['flag_url'];

    public function getFlagUrlAttribute(): ?string
    {
        if ($this->flag) {
            return asset('assets/images/visa_flags/' . $this->flag);
        }

        if ($this->country_code) {
            return 'https://flagcdn.com/w80/' . strtolower($this->country_code) . '.png';
        }

        return null;
    }

    public function visaTypes()
    {
        return $this->hasMany(VisaType::class, 'visa_country_id');
    }

    public function applications()
    {
        return $this->hasManyThrough(
            VisaApplication::class,
            VisaType::class,
            'visa_country_id',
            'visa_type_id',
            'id',
            'id'
        );
    }
}
