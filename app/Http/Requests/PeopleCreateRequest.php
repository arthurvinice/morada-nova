<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PeopleCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'apelido' => 'string|max:255',
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|unique:people,cpf',
            'whatsapp' => 'required|string|unique:people,whatsapp',
            'rua' => 'string|max:255',
            'numero' => 'string|max:255',
            'bairro' => 'string|max:255',
            'complemento' => 'string|max:255',
            'instagram' => 'string|max:255',
            'data_nascimento' => 'date',
            'escolaridade' => 'string|max:255',
            'genero' => 'string|max:255',
        ];
    }
}
