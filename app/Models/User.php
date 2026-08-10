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
        'visa',
        'ticket',
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

    /**
     * Get full URL for profile picture.
     */
    public function getProfilePictureUrlAttribute(): ?string
    {
        return $this->profile_picture ? asset('storage/' . $this->profile_picture) : null;
    }

    /**
     * Get full URL for passport document.
     */
    public function getPassportUrlAttribute(): ?string
    {
        return $this->passport ? asset('storage/' . $this->passport) : null;
    }

    /**
     * Get full URL for cnic document.
     */
    public function getCnicUrlAttribute(): ?string
    {
        return $this->cnic ? asset('storage/' . $this->cnic) : null;
    }

    /**
     * Get full URL for visa document.
     */
    public function getVisaUrlAttribute(): ?string
    {
        return $this->visa ? asset('storage/' . $this->visa) : null;
    }

    /**
     * Get full URL for ticket document.
     */
    public function getTicketUrlAttribute(): ?string
    {
        return $this->ticket ? asset('storage/' . $this->ticket) : null;
    }
}

