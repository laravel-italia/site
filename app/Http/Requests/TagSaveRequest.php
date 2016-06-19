<?php

namespace LaravelItalia\Http\Requests;

class TagSaveRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Specifica il nome del tag!',
        ];
    }
}
