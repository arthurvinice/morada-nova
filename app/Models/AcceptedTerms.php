<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcceptedTerms extends Model
{
    protected $fillable = [
        'ip_address', 
        'user_id', 
        'term_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function term()
    {
        return $this->belongsTo(Terms::class, 'term_id');
    }
}
