<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PindahMasuk extends Model
{
    use HasFactory;

    protected $table = 'pindah_masuk';

    protected $fillable = [
        'warga_id',
        'family_id',
        'lingkungan',
        'alamat',
        'no_kk',
        'tanggal_masuk',
        'asal',
        'jenis_masuk',
        'keterangan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
    ];

    public function warga()
    {
        return $this->belongsTo(BiodataWarga::class, 'warga_id');
    }

    public function family()
    {
        return $this->belongsTo(DataKeluarga::class, 'family_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
