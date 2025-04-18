<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ChangePassRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'usuario' => 'required',
            'password' => 'required',
            'password1' => 'required',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'usuario.required' => 'El campo usuario es obligatorio.',
            'password.required' => 'La contraseña actual es obligatoria.',
            'password1.required' => 'La nueva contraseña es obligatoria.',
        ];
    }
}
