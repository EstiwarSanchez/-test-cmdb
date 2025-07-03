<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCmdbRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'identificador' => 'required|string|max:255',
            'nombre' => 'required|string',
        ];
    }
}
