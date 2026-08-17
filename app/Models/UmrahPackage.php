<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UmrahPackage extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    protected $casts = [
        'durations' => 'array',
    ];

    public function getTypeAttribute()
    {
        return 'umrah';
    }
}
