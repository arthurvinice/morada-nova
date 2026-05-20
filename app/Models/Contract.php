<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contracts';

    protected $fillable = [
        'start_date',
        'end_date',
        'rent_value',
        'status',
        'property_id',
        'people_id',
        'user_id',
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
        return $this->belongsTo(People::class, 'people_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
