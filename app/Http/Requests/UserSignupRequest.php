<?php

namespace app\Http\Requests;

use Illuminate\Http\Request;

class UserSignupRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Hai scordato di specificare il tuo nome!',
            'email.required' => 'Hai scordato di specificare il tuo indirizzo email!',
            'email.email' => 'Devi specificare un indirizzo email valido!',
            'email.unique' => 'Questo indirizzo email esiste già nel nostro database. Effettua il login!',
            'password.required' => 'Hai scordato di specificare la tua password!',
            'password.min' => 'La tua password deve essere lunga almeno sei caratteri.',
        ];
    }
}
