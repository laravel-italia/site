<?php

namespace LaravelItalia\Http\Requests;

class TemplateSaveRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'body' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Specifica un nome per il template!',
            'body.required' => 'Il corpo del template non può essere vuoto!',
        ];
    }
}
