<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataKeluargaSeeder extends Seeder
{
    public function run()
    {
        $kk = '3201012000000001';
        DB::table('data_keluarga')->insert([
            'no_kk' => $kk,
            'nama_kep' => 'Budi Santoso',
            'alamat' => 'Jl. Mawar No.1',
            'lingkungan' => 'Lingkungan 1',
            'status_keluarga' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('biodata_warga')->insert([
            [
                'family_id' => 1,
                'no_kk' => $kk,
                'nik' => '3201012000000001',
                'nama_lgkp' => 'Budi Santoso',
                'jenis_kelamin' => 'L',
                'tgl_lhr' => '1980-01-01',
                'agama' => 'Islam',
                'pendidikan_terakhir' => 'SMA',
                'pekerjaan' => 'Petani',
                'stts_kawin' => 'Kawin',
                'stts_hub_keluarga' => 'Kepala Keluarga',
                'status_warga' => 1,
                'flag_status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 1,
                'no_kk' => $kk,
                'nik' => '3201012000000002',
                'nama_lgkp' => 'Siti Aminah',
                'jenis_kelamin' => 'P',
                'tgl_lhr' => '1985-02-02',
                'agama' => 'Islam',
                'pendidikan_terakhir' => 'SMP',
                'pekerjaan' => 'Ibu Rumah Tangga',
                'stts_kawin' => 'Kawin',
                'stts_hub_keluarga' => 'Istri',
                'status_warga' => 1,
                'flag_status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
