<?php

namespace LaravelItalia\Http\Requests;

class ArticlePublishRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'published_at' => 'required|date_format:"d/m/Y H:i"',
        ];
    }

    public function messages()
    {
        return [
            'published_at.required' => 'Specifica una data di pubblicazione!',
            'published_at.date_format' => 'La data di pubblicazione deve essere nel formato gg/mm/aaaa oo:mm',
        ];
    }
}
