<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /*
        |---------------------------------------------------------------------------------------
        | Se Establece El Valor En "true" Ya Que No Existen Requerimientos Para Validar Si EL
        | Usuario Puede O No Hacer Esta Peticion.
        |---------------------------------------------------------------------------------------
        */

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
        return [
            'bank' => 'required|filled|not_in:0',
            'person_type' => 'required|exists:person_types,id',
            'document_type' => 'required|exists:document_types,name',
            'document' => 'required|numeric|digits_between:1,12',
            'first_name' => 'required|max:60',
            'last_name' => 'required|max:60',
            'email' => 'required|email|max:80',
            'city' => 'required|max:50',
            'province' => 'required|max:50',
        ];
    }


    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'bank' => 'Banco',
            'person_type' => 'Tipo De Persona',
            'document_type' => 'Tipo De Documento',
            'document' => 'Documento',
            'first_name' => 'Nombre',
            'last_name' => 'Apellido',
            'email' => 'Correo Electrónico',
            'city' => 'Ciudad',
            'province' => 'Departamento/Provincia',
        ];
    }
}
