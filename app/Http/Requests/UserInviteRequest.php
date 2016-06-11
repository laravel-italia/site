<?php

namespace LaravelItalia\Http\Requests;

use LaravelItalia\Http\Requests\Request;

class UserInviteRequest extends Request
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
            'name' => 'required',
            'email' => 'required|email|unique:users',
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
            'name.required' => 'Specificare il nome del nuovo editor.',

            'email.required' => 'Specificare un indirizzo email.',
            'email.email' => 'Inserire un indirizzo email valido.',
            'email.unique' => 'L\'indirizzo inserito corrisponde ad un utente già presente.'
        ];
    }
}
