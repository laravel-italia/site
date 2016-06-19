<?php

namespace LaravelItalia\Http\Requests;

class UserPasswordRecoveryRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Hai scordato di specificare il tuo indirizzo email!',
            'email.email' => 'Devi specificare un indirizzo email valido!',
        ];
    }
}
