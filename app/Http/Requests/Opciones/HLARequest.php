<?php

namespace App\Http\Requests\Opciones;

use Illuminate\Foundation\Http\FormRequest;

class HlaRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'year' => 'sometimes|digits:4|integer|min:2000|max:' . (date('Y') + 1),
        ];
    }
}
