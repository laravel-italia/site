<?php

namespace LaravelItalia\Http\Requests;

class SeriesSaveRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Specifica un titolo per la serie!',
            'description.required' => 'Devi specificare una descrizione della serie!',
        ];
    }
}
