<?php

namespace LaravelItalia\Http\Requests;

class UserLoginRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ];
    }

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
