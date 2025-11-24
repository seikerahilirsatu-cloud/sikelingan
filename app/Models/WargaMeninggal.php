<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WargaMeninggal extends Model
{
    use HasFactory;

    protected $table = 'warga_meninggal';

    protected $fillable = [
        'warga_id',
        'family_id',
        'lingkungan',
        'alamat',
        'no_kk',
        'tanggal_meninggal',
        'sebab_meninggal',
        'waktu_meninggal',
        'tempat_meninggal',
        'tanggal_dikebumikan',
        'keterangan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_meninggal' => 'date',
        'tanggal_dikebumikan' => 'date',
        // 'time' is not a built-in cast type in Laravel; store as string
        'waktu_meninggal' => 'string',
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
