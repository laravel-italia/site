<?php

namespace LaravelItalia\Http\Requests;

use LaravelItalia\Http\Requests\Request;

class ChangeProfilePictureRequest extends Request
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
            'picture' => 'required|image'
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
            'picture.required' => 'Scegli un\'immagine da caricare.',
            'picture.image' => 'Caricare un file immagine valido.'
        ];
    }
}
