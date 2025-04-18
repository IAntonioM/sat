<?php

namespace App\Http\Requests\Opciones;

use Illuminate\Foundation\Http\FormRequest;

class DetalladoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Autorizar todas las solicitudes, se controla en el middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'anio' => 'nullable|string',
            'tipo_tributo' => 'nullable|string',
            'id_recibos' => 'nullable|array',
            'id_recibos.*' => 'string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'id_recibos.array' => 'El formato de los recibos seleccionados no es válido',
        ];
    }
}
