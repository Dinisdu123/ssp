<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable;

    protected $connection = 'mysql';

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
        'email_verified_at',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
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

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function createTokenForRole()
    {
        $abilities = $this->isAdmin() ? ['admin-access', 'product:manage', 'order:manage'] : ['user-access'];
        return $this->createToken('auth_token', $abilities);
    }
}