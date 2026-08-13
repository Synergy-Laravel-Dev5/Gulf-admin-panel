<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'role',
        'profile_picture',
        'phone',
        'passport',
        'cnic',
        'cnic_front',
        'cnic_back',
        'visa',
        'ticket',
        'otp_code',
        'user_type',
        'company_name',
        'logo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    private function getUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        if (str_starts_with($path, 'storage/')) {
            return asset(str_replace('storage/', 'uploads/', $path));
        }
        if (str_starts_with($path, 'uploads/')) {
            return asset($path);
        }
        if (str_starts_with($path, 'profile_pictures/') || str_starts_with($path, 'user_documents/')) {
            return asset('uploads/' . $path);
        }
        return asset($path);
    }

    public function getProfilePictureUrlAttribute(): ?string
    {
        return $this->getUrl($this->profile_picture);
    }

    public function getPassportUrlAttribute(): ?string
    {
        return $this->getUrl($this->passport);
    }

    public function getCnicUrlAttribute(): ?string
    {
        return $this->getUrl($this->cnic);
    }

    public function getCnicFrontUrlAttribute(): ?string
    {
        return $this->getUrl($this->cnic_front ?? $this->cnic);
    }

    public function getCnicBackUrlAttribute(): ?string
    {
        return $this->getUrl($this->cnic_back);
    }

    public function getVisaUrlAttribute(): ?string
    {
        return $this->getUrl($this->visa);
    }

    public function getTicketUrlAttribute(): ?string
    {
        return $this->getUrl($this->ticket);
    }

    public function getLogoUrlAttribute(): ?string
    {
        if (!$this->logo) {
            return null;
        }
        if (str_starts_with($this->logo, 'http://') || str_starts_with($this->logo, 'https://')) {
            return $this->logo;
        }
        return asset($this->logo);
    }
}
