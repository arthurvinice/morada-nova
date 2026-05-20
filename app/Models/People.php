<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class People extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'people';

    protected $fillable = [
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
