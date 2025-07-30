<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ROLE_STAFF = 'Staff';
    const ROLE_SECRETARY = 'Secretary';
    const ROLE_TREASURER = 'Treasurer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
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
    public function isStuff(): bool
    {
        return $this->role === self::ROLE_STAFF;
    }

    public function isSecretary(): bool
    {
        return $this->role === self::ROLE_SECRETARY;
    }

    public function isTreasurer(): bool
    {
        return $this->role === self::ROLE_TREASURER;
    }

    public static function getRoles(): array
    {
        return [
            self::ROLE_STAFF,
            self::ROLE_SECRETARY,
            self::ROLE_TREASURER,
        ];
    }
}