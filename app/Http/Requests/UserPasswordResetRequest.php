<?php

namespace LaravelItalia\Http\Requests;

class UserPasswordResetRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'token' => 'required',
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
            'email.required' => 'Hai scordato di specificare il tuo indirizzo email!',
            'email.email' => 'Devi specificare un indirizzo email valido!',
            'password.required' => 'Hai scordato di specificare una nuova password!',
            'password.confirmed' => 'La conferma della password deve combaciare con quella scelta.',
            'token.required' => 'Nella tua richiesta non è stato trovato il token di sicurezza. Riprova.',
        ];
    }
}
