<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name' => 'required|min:3|string|max:255',
            'whatsapp' => 'required|string|max:255',
            'email' => 'required|string|unique:users,email,'. $this->id .',id',
            'password' => 'nullable|min:8|string|max:255',
            'is_ativo' => 'required',
            'nivel' => 'required',
        ];
    }
}
