<?php

namespace LaravelItalia\Http\Requests;

class ArticleAddRequest extends Request
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
            'title' => 'required',
            'body' => 'required',
            'categories' => 'required',
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
            'title.required' => 'Specifica un titolo per il tuo articolo!',
            'body.required' => 'Non puoi aggiungere un articolo senza contenuto!',
            'categories.required' => 'Devi specificare almeno una categoria di riferimento!',
        ];
    }
}
