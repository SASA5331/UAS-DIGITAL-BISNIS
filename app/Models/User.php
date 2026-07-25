<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role',
        'google_id', 'avatar', 'organization_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    // Cek apakah user adalah superadmin
    public function isSuperAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Cek apakah user adalah penyelenggara (organizer)
    public function isOrganizer(): bool
    {
        return $this->role === 'organizer';
    }
}