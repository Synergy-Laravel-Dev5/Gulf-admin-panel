<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageBooking extends Model
{
    protected $fillable = [
        'package_id',
        'package_type',
        'user_id',
        'full_name',
        'cnic',
        'passport_number',
        'phone',
        'email',
        'room_type',
        'next_of_kin_name',
        'next_of_kin_contact',
        'status',
        'notes',
        'payment_proof',
    ];

    protected $appends = [
        'payment_proof_url',
    ];

    public function package()
    {
        return $this->morphTo(__FUNCTION__, 'package_type', 'package_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPaymentProofUrlAttribute(): ?string
    {
        if (!$this->payment_proof) {
            return null;
        }

        if (str_starts_with($this->payment_proof, 'http://') || str_starts_with($this->payment_proof, 'https://')) {
            return $this->payment_proof;
        }

        return asset($this->payment_proof);
    }
}