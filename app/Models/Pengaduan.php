<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_tiket',
        'nama',
        'kontak',
        'kategori',
        'judul',
        'isi',
        'lokasi',
        'lampiran',
        'status',
        'ip_address',
        'user_agent',
        'handled_by',
        'handled_notes',
        'public_notes',
        'handled_at',
    ];

    protected $casts = [
        'lampiran' => 'array',
        'handled_at' => 'datetime',
    ];
}
