<?php

namespace App\Http\Requests\Opciones;

use Illuminate\Foundation\Http\FormRequest;

class HlaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check(); // Only logged-in users can access
    }

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
