<?php

namespace App\Http\Requests\Opciones;

use App\Models\Usuario;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class UsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'usuario' => 'required|string|max:255',
            'fechaRegistro' => 'required|date',
            'estado' => 'required|boolean',
            'tipoAdministrador' => 'required|boolean',
        ];

        // Validar password solo en creación o si se modifica
        if (!$this->filled('user_id') || $this->filled('password')) {
            $rules['password'] = 'required|string|min:6';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            // tus mensajes personalizados, igual que los que ya tienes
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

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        if ($this->filled('user_id')) {
            Session::flash('modal_open_edit', true);
            Session::flash('user_id', $this->input('user_id'));
        } else {
            Session::flash('modal_open_add', true);
        }

        parent::failedValidation($validator);
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $nuevoNroDoc = trim($this->input('usuario'));
            $userId = $this->input('user_id');

            // Si se está creando o el nroDoc cambió
            if (!$userId) {
                if (Usuario::existeNroDocumento($nuevoNroDoc)) {
                    $validator->errors()->add('usuario', 'El número de documento ya está registrado.');
                }
            } else {

                    if ($userId !== $nuevoNroDoc) {
                        if (Usuario::existeNroDocumento($nuevoNroDoc)) {
                            $validator->errors()->add('usuario', 'El número de documento ya está registrado por otro usuario.');
                        }
                    }
            }
        });
    }
}
