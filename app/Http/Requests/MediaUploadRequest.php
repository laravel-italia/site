<?php

namespace LaravelItalia\Http\Requests;

class MediaUploadRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'media' => 'required|mimes:jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'media.required' => 'Scegliere un file per procedere con il caricamento.',
            'media.mimes' => 'Il file da caricare deve essere un jpg o png. Altri formati non sono ammessi.',
            'media.max' => 'Il file da caricare può essere grande, al massimo, 2MB.',
        ];
    }
}
