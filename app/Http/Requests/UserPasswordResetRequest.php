<?php

namespace LaravelItalia\Http\Requests;

class UserPasswordResetRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'token' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Hai scordato di specificare il tuo indirizzo email!',
            'email.email' => 'Devi specificare un indirizzo email valido!',
            'password.required' => 'Hai scordato di specificare una nuova password!',
            'password.confirmed' => 'La conferma della password deve combaciare con quella scelta.',
            'token.required' => 'Nella tua richiesta non è stato trovato il token di sicurezza. Riprova.',
        ];
    }
}
