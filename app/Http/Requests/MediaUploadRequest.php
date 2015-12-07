<?php

namespace LaravelItalia\Http\Requests;

class MediaUploadRequest extends Request
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
            'media' => 'required|mimes:jpeg,png|max:2048'
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
            'media.required'    => 'Scegliere un file per procedere con il caricamento.',
            'media.mimes'       => 'Il file da caricare deve essere un jpg o png. Altri formati non sono ammessi.',
            'media.max'         => 'Il file da caricare può essere grande, al massimo, 2MB.'
        ];
    }
}
