<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPasswordUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->id == $this->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'currentPassword' => 'required|min:8|max:80',
            'password' => 'required|min:8|max:80',
            'password_confirmation' => 'required|min:8|same:password',
        ];
    }

    public function messages()
    {
        return [
            'currentPassword.required' => 'O campo Senha Atual é obrigatório',
        ];
    }
}
