<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangelogCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome'
    ];

    /**
     * Scope para buscar por nome
     */
    public function scopeByName($query, string $name)
    {
        return $query->where('nome', 'like', "%{$name}%");
    }
}
