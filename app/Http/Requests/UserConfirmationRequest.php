<?php

namespace LaravelItalia\Http\Requests;

class UserConfirmationRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'code' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'confirmation_code.required' => 'Non è stato specificato un codice di conferma.',
        ];
    }
}
