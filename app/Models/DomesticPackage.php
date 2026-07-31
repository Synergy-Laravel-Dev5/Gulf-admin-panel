<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DomesticPackage extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function getTypeAttribute()
    {
        return 'domestic';
    }
}
