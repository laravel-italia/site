<?php

namespace LaravelItalia\Http\Requests;

class SaveCategoryRequest extends Request
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
            'name.required' => 'Non è stato specificato un nome per la categoria.',
        ];
    }
}
