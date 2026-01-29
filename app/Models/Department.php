<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cnpj',
        'logo',
        'email',
        'telefone_principal',
        'telefone_secundario',
        'rua',
        'numero',
        'bairro',
        'cidade',
        'cep',
        'uf',
        'complemento',
        'send_message',
        'webhook_n8n_service',
        'webhook_n8n_order',
        'webhook_n8n_campaign',
    ];
}
