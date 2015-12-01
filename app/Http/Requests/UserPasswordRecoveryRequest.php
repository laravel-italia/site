<?php

namespace LaravelItalia\Http\Requests;


class UserPasswordRecoveryRequest extends Request
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
            'email'     => 'required|email'
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
            'email.required'    => 'Hai scordato di specificare il tuo indirizzo email!',
            'email.email'       => 'Devi specificare un indirizzo email valido!',
        ];
    }
}
