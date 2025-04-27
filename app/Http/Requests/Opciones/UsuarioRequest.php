<?php

namespace App\Http\Requests\Opciones;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
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
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'usuario' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'fechaRegistro' => 'required|date',
            'estado' => 'required|boolean',
            'tipoAdministrador' => 'required|boolean'
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nombres.required' => 'El campo nombres es obligatorio.',
            'nombres.string' => 'El campo nombres debe ser texto.',
            'nombres.max' => 'El campo nombres no debe exceder los 255 caracteres.',

            'apellidos.required' => 'El campo apellidos es obligatorio.',
            'apellidos.string' => 'El campo apellidos debe ser texto.',
            'apellidos.max' => 'El campo apellidos no debe exceder los 255 caracteres.',

            'usuario.required' => 'El campo usuario es obligatorio.',
            'usuario.string' => 'El campo usuario debe ser texto.',
            'usuario.max' => 'El campo usuario no debe exceder los 255 caracteres.',

            'password.required' => 'El campo contraseña es obligatorio.',
            'password.string' => 'El campo contraseña debe ser texto.',
            'password.min' => 'El campo contraseña debe tener al menos 6 caracteres.',

            'fechaRegistro.required' => 'El campo fecha de registro es obligatorio.',
            'fechaRegistro.date' => 'El campo fecha de registro debe ser una fecha válida.',

            'estado.required' => 'El campo estado es obligatorio.',
            'estado.boolean' => 'El campo estado debe ser un valor booleano.',

            'tipoAdministrador.required' => 'El campo tipo de administrador es obligatorio.',
            'tipoAdministrador.boolean' => 'El campo tipo de administrador debe ser un valor booleano.',
        ];
    }
}
