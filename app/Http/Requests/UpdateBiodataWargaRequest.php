<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBiodataWargaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('biodata_warga')?->id;
        return [
            'family_id' => 'nullable|exists:data_keluarga,id',
            'no_kk' => 'nullable|exists:data_keluarga,no_kk',
            'lingkungan' => ['nullable','string','max:20', function($attr, $value, $fail){
                $opts = config('app_local.lingkungan_opts', []);
                if ($value && !in_array($value, $opts)) $fail('Invalid lingkungan');
            }],
            'nik' => 'required|digits:16|unique:biodata_warga,nik,' . $id,
            'nama_lgkp' => 'required|string|max:150',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tmpt_lahir' => 'nullable|string|max:150',
            'tgl_lhr' => 'nullable|date',
            'agama' => ['nullable','string','max:50', function($attr, $value, $fail){
                $opts = config('biodata_config.agama', []);
                if ($value && !in_array($value, $opts)) $fail('Invalid agama');
            }],
            'pendidikan_terakhir' => ['nullable','string','max:100', function($attr, $value, $fail){
                $opts = config('biodata_config.pendidikan_terakhir', []);
                if ($value && !in_array($value, $opts)) $fail('Invalid pendidikan_terakhir');
            }],
            'pekerjaan' => ['nullable','string','max:100', function($attr, $value, $fail){
                $opts = config('biodata_config.pekerjaan', []);
                if ($value && !in_array($value, $opts)) $fail('Invalid pekerjaan');
            }],
            'stts_kawin' => ['nullable','string','max:50', function($attr, $value, $fail){
                $opts = config('biodata_config.stts_kawin', []);
                if ($value && !in_array($value, $opts)) $fail('Invalid stts_kawin');
            }],
            'stts_hub_keluarga' => ['nullable','string','max:50', function($attr, $value, $fail){
                $opts = config('biodata_config.stts_hub_keluarga', []);
                if ($value && !in_array($value, $opts)) $fail('Invalid stts_hub_keluarga');
            }],
        ];
    }
}
