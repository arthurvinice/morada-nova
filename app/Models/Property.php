<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasUuid;

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

    public function activeContract()
    {
        return $this->hasOne(Contract::class)->where('status', 'active');
    }
}