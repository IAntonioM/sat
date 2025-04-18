<?php

namespace App\Http\Requests\Opciones;

use Illuminate\Foundation\Http\FormRequest;

class DeudaConsolidadaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Ajusta según tus reglas de autorización
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
            'recibos_seleccionados' => 'nullable|array',
            'recibos_seleccionados.*' => 'string'
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
            'anio.string' => 'El año debe ser una cadena de texto válida.',
            'tipo_tributo.string' => 'El tipo de tributo debe ser una cadena de texto válida.',
            'recibos_seleccionados.array' => 'Los recibos seleccionados deben ser un arreglo.',
        ];
    }
}
