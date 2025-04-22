<?php

namespace App\Http\Requests\Auth;

use App\Models\TipoDocumento;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SolicitudAccesoRequest extends FormRequest
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
        $rules = [
            'iTipoDocuId' => 'required|string|exists:T_DOC,id_doc',
            'cAsunto' => 'required|string|max:255',
            'cDireccion' => 'required|string|max:255',
            'correoDestino' => 'required|email|max:100',
            'telefono' => 'required|string|max:20',
            'archivo' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];

        // Obtener el tipo de documento seleccionado
        $tipoDocId = $this->input('iTipoDocuId');

        // Buscar el tipo de documento en la base de datos
        $tipoDocumento = null;
        if ($tipoDocId) {
            $tiposDocumento = TipoDocumento::obtenerTipoDocs($tipoDocId);
            if (!empty($tiposDocumento)) {
                $tipoDocumento = $tiposDocumento[0];
            }
        }

        // Validar el número de documento según el tipo
        if ($tipoDocumento && $tipoDocumento->digitos > 0) {
            $rules['nNumDocuId'] = [
                'required',
                'string',
                'digits:' . $tipoDocumento->digitos
            ];
        } else {
            $rules['nNumDocuId'] = 'required|string|max:20';
        }

        // Si es RUC (02), requerir razón social, si no, requerir nombres y apellidos
        if ($tipoDocId === '02') {
            $rules['cRazonSocial'] = 'required|string|max:255';
            $rules['cApePate'] = 'nullable|string|max:100';
            $rules['cApeMate'] = 'nullable|string|max:100';
            $rules['cNombres'] = 'nullable|string|max:100';
        } else {
            $rules['cRazonSocial'] = 'nullable|string|max:255';
            $rules['cApePate'] = 'required|string|max:100';
            $rules['cApeMate'] = 'required|string|max:100';
            $rules['cNombres'] = 'required|string|max:100';
        }

        return $rules;
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'iTipoDocuId.required' => 'El tipo de documento es obligatorio.',
            'iTipoDocuId.exists' => 'El tipo de documento seleccionado no es válido.',

            'nNumDocuId.required' => 'El número de documento es obligatorio.',
            'nNumDocuId.max' => 'El número de documento no puede exceder los 20 caracteres.',
            'nNumDocuId.digits' => 'El número de documento debe tener exactamente :digits dígitos.',

            'cRazonSocial.required' => 'La razón social es obligatoria para documentos de tipo RUC.',
            'cRazonSocial.max' => 'La razón social no puede exceder los 255 caracteres.',

            'cApeMate.required' => 'El apellido paterno es obligatorio.',
            'cApeMate.max' => 'El apellido paterno no puede exceder los 100 caracteres.',

            'cApePate.required' => 'El apellido materno es obligatorio.',
            'cApePate.max' => 'El apellido paterno no puede exceder los 100 caracteres.',

            'cNombres.required' => 'Los nombres son obligatorios.',
            'cNombres.max' => 'Los nombres no pueden exceder los 100 caracteres.',

            'cAsunto.required' => 'El asunto es obligatorio.',
            'cAsunto.max' => 'El asunto no puede exceder los 255 caracteres.',

            'cDireccion.required' => 'La dirección es obligatoria.',
            'cDireccion.max' => 'La dirección no puede exceder los 255 caracteres.',

            'correoDestino.required' => 'El correo electrónico es obligatorio.',
            'correoDestino.email' => 'Debe ingresar un correo electrónico válido.',
            'correoDestino.max' => 'El correo electrónico no puede exceder los 100 caracteres.',

            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.max' => 'El teléfono no puede exceder los 20 caracteres.',

            'archivo.required' => 'Debe adjuntar un archivo.',
            'archivo.file' => 'El archivo adjunto no es válido.',
            'archivo.mimes' => 'El archivo debe ser de tipo: pdf, jpg, jpeg o png.',
            'archivo.max' => 'El archivo no debe exceder los 2MB.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // You can modify input data here before validation if needed
        $this->merge([
            'cEstacionSolicitud' => $this->ip(),
        ]);
    }
}
