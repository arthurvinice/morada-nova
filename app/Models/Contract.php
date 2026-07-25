<?php

namespace App\Models;

use App\Models\Concerns\BelongsToConfiguration;
use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasUuid, BelongsToConfiguration;

    protected $table = 'contracts';

    protected $fillable = [
        'uuid',
        'start_date',
        'end_date',
        'payday',
        'rent_value',
        'status',
        'property_id',
        'people_id',
        'user_id',
        'configuration_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'rent_value' => 'decimal:2',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function people()
    {
        return $this->belongsTo(People::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function configuration()
    {
        return $this->belongsTo(Configuration::class);
    }
}