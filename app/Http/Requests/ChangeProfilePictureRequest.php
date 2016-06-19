<?php

namespace LaravelItalia\Http\Requests;

class ChangeProfilePictureRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'picture' => 'required|image'
        ];
    }

    public function messages()
    {
        return [
            'picture.required' => 'Scegli un\'immagine da caricare.',
            'picture.image' => 'Caricare un file immagine valido.'
        ];
    }
}
