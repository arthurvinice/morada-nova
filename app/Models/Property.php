<?php

namespace App\Models;

use App\Models\Concerns\BelongsToConfiguration;
use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasUuid, BelongsToConfiguration, HasFactory;

    protected $table = 'properties';

    protected $fillable = [
        'uuid',
        'nickname',
        'street',
        'number',
        'city',
        'state',
        'zip_code',
        'complement',
        'description',
        'rent_value',
        'status',
        'user_id',
        'property_type_id',
        'configuration_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function configuration()
    {
        return $this->belongsTo(Configuration::class);
    }

    public function activeContract()
    {
        return $this->hasOne(Contract::class)->where('status', 'active');
    }
}