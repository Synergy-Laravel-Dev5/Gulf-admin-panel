<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FlightRequest extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'departure_date'   => 'date',
        'return_date'      => 'date',
        'multi_city_legs'  => 'array',
        'adults'           => 'integer',
        'children'         => 'integer',
        'infants'          => 'integer',
    ];

    protected $appends = [
        'passport_document_url',
        'documents_upload_url',
    ];

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

        if (str_starts_with($path, 'flight_requests/')) {
            return asset('uploads/' . $path);
        }

        return asset($path);
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
