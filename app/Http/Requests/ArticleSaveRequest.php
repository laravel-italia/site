<?php

namespace LaravelItalia\Http\Requests;

class ArticleSaveRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required',
            'body' => 'required',
            'categories' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Specifica un titolo per il tuo articolo!',
            'body.required' => 'Non puoi aggiungere un articolo senza contenuto!',
            'categories.required' => 'Devi specificare almeno una categoria di riferimento!',
        ];
    }
}
