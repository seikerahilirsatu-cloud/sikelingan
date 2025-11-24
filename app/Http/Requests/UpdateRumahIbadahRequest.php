<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRumahIbadahRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nama' => 'required|string|max:150',
            'jenis' => 'required|in:Masjid,Gereja,Pura,Vihara,Klenteng,Mushalla,Lainnya',
            'alamat' => 'required|string',
            'lingkungan' => 'nullable|in:I,II,III,IV,V,VI,VII,VIII,IX,X,XI,XII,XIII',
            'status_operasional' => 'required|in:Aktif,Tidak Aktif',
            'kapasitas' => 'nullable|integer|min:0',
            'tanggal_berdiri' => 'nullable|date',
            'pengurus_nik' => 'nullable|digits:16|exists:biodata_warga,nik',
            'kontak' => 'nullable|string|max:100',
            'koordinat_lat' => 'nullable|numeric',
            'koordinat_lng' => 'nullable|numeric',
            'photo_path' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:5120',
        ];
    }
}