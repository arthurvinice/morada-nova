<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class People extends Model
{
    use HasFactory, Notifiable, HasUuid;

    protected $table = 'people';

    protected $fillable = [
        'uuid',
        'name',
        'cpf',
        'phone',
        'email',
        'document',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}