<?php

namespace LaravelItalia\Http\Requests;

class UserLoginRequest extends Request
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
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'Inserire l\'indirizzo email.',
            'email.email' => 'Inserire un indirizzo email valido.',
            'email.exists' => 'L\'indirizzo inserito non è registrato nel database.',

            'password.required'  => 'Specificare una password.'
        ];
    }
}
