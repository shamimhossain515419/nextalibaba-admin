<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable;

    protected $connection = 'mongodb';
    protected $collection = 'users';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token', 'two_factor_recovery_codes', 'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the URL to the user's profile photo.
     * If no photo exists, return a default avatar.
     */
    public function getProfilePhotoUrlAttribute($value)
    {
        if ($value) {
            // Check if it's a full URL or relative path
            if (filter_var($value, FILTER_VALIDATE_URL)) {
                return $value;
            }

            // Check if file exists
            if (file_exists(public_path($value))) {
                return asset($value);
            }
        }

        // Return default avatar
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=random&color=fff&size=128';
    }

    /**
     * Get the raw profile photo path (without default fallback)
     */
    public function getRawProfilePhotoUrlAttribute()
    {
        return $this->attributes['profile_photo_url'] ?? null;
    }
}
