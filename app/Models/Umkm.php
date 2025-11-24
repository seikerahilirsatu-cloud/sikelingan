<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    protected $table = 'umkm';

    protected $fillable = [
        'nama_usaha',
        'jenis',
        'alamat',
        'lingkungan',
        'status_operasional',
        'pemilik_nik',
        'kontak',
        'tanggal_berdiri',
        'omzet',
        'koordinat_lat',
        'koordinat_lng',
        'photo_path',
        'npwp_pemilik',
        'no_nib',
    ];
}