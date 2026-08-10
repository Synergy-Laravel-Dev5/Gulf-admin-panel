<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tutorial extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'video_url',
        'video_file',
        'thumbnail',
        'category',
        'status',
    ];

    protected $appends = [
        'thumbnail_url',
        'video_file_url',
    ];

    /**
     * Get full URL for thumbnail.
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : null;
    }

    /**
     * Get full URL for uploaded video file.
     */
    public function getVideoFileUrlAttribute(): ?string
    {
        return $this->video_file ? asset('storage/' . $this->video_file) : null;
    }
}
