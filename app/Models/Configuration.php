<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_fantasia',
        'razao_social',
        'cnpj',
        'telefone_principal',
        'whatsapp',
        'email',
        'logo',
        'avatar',
        'address_id',
        'rua',
        'numero',
        'bairro',
        'cidade',
        'cep',
        'estado',
        'custom_client_id',
    ];

    // Uma Configuration pertence a um Address
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
