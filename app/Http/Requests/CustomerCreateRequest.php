<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'dni' => 'required|string|max:11|unique:customers',
            'id_reg' => 'required|integer',
            'id_com' => 'required|integer',
            'email' => 'required|string|email|max:255|unique:customers',
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'date_reg' => 'required|date',
            'status' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'dni.required' => 'El campo :attribute es obligatorio',
            'dni.max' => 'El campo :attribute debe ser maximo 11 caracteres',
            'dni.unique' => 'El campo :attribute ya existe intente con otro',
            'id_reg.required' => 'El campo :attribute es obligatorio',
            'id_com.required' => 'El campo :attribute es obligatorio',
            'email.required' => 'El campo :attribute es obligatorio',
            'email.email' => 'El campo :attribute debe ser de tipo Email',
            'email.unique' => 'El campo :attribute ya existe intente con otro',
            'name.required' => 'El campo :attribute es obligatorio',
            'last_name.required' => 'El campo :attribute es obligatorio',
            'address.required' => 'El campo :attribute es obligatorio',
            'date_reg.required' => 'El campo :attribute es obligatorio',
            'status.required' => 'El campo :attribute es obligatorio'
        ];
    }

    public function attributes()
    {
        return [
            'id_reg' => 'region',
            'id_com' => 'comuna',
            'name' => 'nombre',
            'last_name' => 'apellidos',
            'address' => 'direccion',
            'date_reg' => 'fecha de registro',
            'status' => 'Estatus del cliente'
        ];
    }
}
