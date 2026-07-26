<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasUuid, HasFactory;

    protected $table = 'configurations';

    protected $fillable = [
        'uuid',
        'name',
        'status',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
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
}