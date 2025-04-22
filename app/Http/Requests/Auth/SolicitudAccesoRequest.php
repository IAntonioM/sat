<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'iTipoDocuId' => 'required|numeric',
            'nNumDocuId' => 'required|string|max:20',
            'cRazonSocial' => 'required_without_all:cApePate,cApeMate,cNombres|string|max:255',
            'cApePate' => 'required_without:cRazonSocial|string|max:100',
            'cApeMate' => 'nullable|string|max:100',
            'cNombres' => 'required_without:cRazonSocial|string|max:100',
            'cAsunto' => 'required|string|max:255',
            'cDireccion' => 'required|string|max:255',
            'correoDestino' => 'required|email|max:100',
            'telefono' => 'required|string|max:20',
            'archivo' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'iTipoDocuId.required' => 'El tipo de documento es obligatorio.',
            'iTipoDocuId.numeric' => 'El tipo de documento debe ser numérico.',

            'nNumDocuId.required' => 'El número de documento es obligatorio.',
            'nNumDocuId.max' => 'El número de documento no puede exceder los 20 caracteres.',

            'cRazonSocial.required_without_all' => 'La razón social es obligatoria cuando no se proporcionan nombres y apellidos.',
            'cRazonSocial.max' => 'La razón social no puede exceder los 255 caracteres.',

            'cApePate.required_without' => 'El apellido paterno es obligatorio cuando no se proporciona razón social.',
            'cApePate.max' => 'El apellido paterno no puede exceder los 100 caracteres.',

            'cApeMate.max' => 'El apellido materno no puede exceder los 100 caracteres.',

            'cNombres.required_without' => 'Los nombres son obligatorios cuando no se proporciona razón social.',
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
