<?php

namespace App\Models;

use App\Models\Concerns\BelongsToConfiguration;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, BelongsToConfiguration;

    protected $fillable = [
        'uuid',
        'name',
        'cpf',
        'email',
        'phone',
        'image',
        'password',
        'role',
        'status',
        'configuration_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function people()
    {
        return $this->hasMany(People::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function configuration()
    {
        return $this->belongsTo(Configuration::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}