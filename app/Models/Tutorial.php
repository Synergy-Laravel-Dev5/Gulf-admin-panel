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

    private function formatUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        return asset($path);
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->formatUrl($this->thumbnail);
    }

    public function getVideoFileUrlAttribute(): ?string
    {
        return $this->formatUrl($this->video_file);
    }
}
