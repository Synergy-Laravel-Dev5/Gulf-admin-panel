<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelBooking extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $appends = [
        'payment_proof_url',
        'documents_upload_url',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    private function getUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'uploads/')) {
            return asset($path);
        }

        if (str_starts_with($path, 'hotel_bookings/')) {
            return asset('uploads/' . $path);
        }

        return asset($path);
    }

    public function getPaymentProofUrlAttribute(): ?string
    {
        return $this->getUrl($this->payment_proof);
    }

    public function getDocumentsUploadUrlAttribute(): ?string
    {
        return $this->getUrl($this->documents_upload);
    }
}
