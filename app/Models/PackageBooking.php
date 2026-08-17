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
        'passport_document',
        'documents_upload',
    ];

    protected $appends = [
        'payment_proof_url',
        'passport_document_url',
        'documents_upload_url',
    ];

    public function package()
    {
        return $this->morphTo(__FUNCTION__, 'package_type', 'package_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    private function getUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset($path);
    }

    public function getPaymentProofUrlAttribute(): ?string
    {
        return $this->getUrl($this->payment_proof);
    }

    public function getPassportDocumentUrlAttribute(): ?string
    {
        return $this->getUrl($this->passport_document);
    }

    public function getDocumentsUploadUrlAttribute(): ?string
    {
        return $this->getUrl($this->documents_upload);
    }
}