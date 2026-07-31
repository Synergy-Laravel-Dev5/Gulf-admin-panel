<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HajjPackage extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    protected $casts = [
        'requirements' => 'array',
    ];

    public function getTypeAttribute()
    {
        return 'hajj';
    }
}