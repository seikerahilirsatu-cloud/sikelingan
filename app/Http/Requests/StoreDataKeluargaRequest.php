<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDataKeluargaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'no_kk' => 'required|digits:16|unique:data_keluarga,no_kk',
            'nama_kep' => 'required|string|max:150',
            'alamat' => 'required|string',
            'lingkungan' => ['nullable', Rule::in(config('data_keluarga_config.lingkungan'))],
            'status_keluarga' => 'required|in:1,2,3',
        ];
    }
}
