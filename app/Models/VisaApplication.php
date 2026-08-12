<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaApplication extends Model
{
    use HasFactory;


    protected $fillable = [
        'visa_type_id',
        'full_name',
        'phone',
        'email',
        'cnic',
        'passport_scan',
        'picture',
        'cnic_front',
        'cnic_back',
        'bank_statement',
        'other_document',
        'status',
        'remarks',
    ];


    public function visaType()
    {
        return $this->belongsTo(VisaType::class, 'visa_type_id');
    }

    protected $appends = [
        'passport_scan_url',
        'picture_url',
        'cnic_front_url',
        'cnic_back_url',
        'bank_statement_url',
        'other_document_url',
    ];

    private function getDocUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        // If it starts with 'visa_documents/' (legacy storage path)
        if (str_starts_with($path, 'visa_documents/')) {
            return asset('uploads/' . $path);
        }
        return asset($path);
    }

    public function getPassportScanUrlAttribute(): ?string
    {
        return $this->getDocUrl($this->passport_scan);
    }

    public function getPictureUrlAttribute(): ?string
    {
        return $this->getDocUrl($this->picture);
    }

    public function getCnicFrontUrlAttribute(): ?string
    {
        return $this->getDocUrl($this->cnic_front);
    }

    public function getCnicBackUrlAttribute(): ?string
    {
        return $this->getDocUrl($this->cnic_back);
    }

    public function getBankStatementUrlAttribute(): ?string
    {
        return $this->getDocUrl($this->bank_statement);
    }

    public function getOtherDocumentUrlAttribute(): ?string
    {
        return $this->getDocUrl($this->other_document);
    }
}

