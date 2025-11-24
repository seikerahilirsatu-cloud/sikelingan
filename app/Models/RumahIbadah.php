<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RumahIbadah extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rumah_ibadah';

    protected $fillable = [
        'nama',
        'jenis',
        'alamat',
        'lingkungan',
        'status_operasional',
        'kapasitas',
        'tanggal_berdiri',
        'pengurus_nik',
        'kontak',
        'koordinat_lat',
        'koordinat_lng',
        'photo_path',
    ];

    public function pengurus()
    {
        return $this->belongsTo(BiodataWarga::class, 'pengurus_nik', 'nik');
    }
}