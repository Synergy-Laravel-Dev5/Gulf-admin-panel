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
    
}
