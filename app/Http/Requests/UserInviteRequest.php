<?php

namespace LaravelItalia\Http\Requests;

class UserInviteRequest extends Request
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
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Specificare il nome del nuovo editor.',

            'email.required' => 'Specificare un indirizzo email.',
            'email.email' => 'Inserire un indirizzo email valido.',
            'email.unique' => 'L\'indirizzo inserito corrisponde ad un utente già presente.'
        ];
    }
}
