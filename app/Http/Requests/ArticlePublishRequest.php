<?php

namespace LaravelItalia\Http\Requests;

use LaravelItalia\Http\Requests\Request;

class ArticlePublishRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'published_at' => 'required|date_format:"d/m/Y H:i"'
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
            'published_at.required' => 'Specifica una data di pubblicazione!',
            'published_at.date_format' => 'La data di pubblicazione deve essere nel formato gg/mm/aaaa oo:mm'
        ];
    }
}
