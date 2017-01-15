<?php

namespace LaravelItalia\Http\Requests;

class MapEntryAddRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'description' => 'required|max:255',
            'type' => 'required',

            'latitude' => 'required',
            'longitude' => 'required',
            'region' => 'required',
            'city' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Non scordare di inserire il nome!',
            'description.required' => 'Devi scrivere una descrizione di qualche riga per raccontare te o la tua azienda.',
            'type.required' => 'Devi specificare se ti stai aggiungendo come azienda o come sviluppatore!',

            'latitude.required' => 'Ricontrolla l\'indirizzo inserito, perchè non è stato riconosciuto come valido! Assicurati che almeno la città sia specificata.',
            'longitude.required' => 'Ricontrolla l\'indirizzo inserito, perchè non è stato riconosciuto come valido! Assicurati che almeno la città sia specificata.',
            'region.required' => 'Ricontrolla l\'indirizzo inserito, perchè non è stato riconosciuto come valido! Assicurati che almeno la città sia specificata.',
            'city.required' => 'Ricontrolla l\'indirizzo inserito, perchè non è stato riconosciuto come valido! Assicurati che almeno la città sia specificata.',
        ];
    }
}
