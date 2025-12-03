<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PendidikanNonFormal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pendidikan_non_formal';

    protected $fillable = [
        'nama_lembaga','bidang_pelatihan','tahun_berdiri','sk_pendirian','alamat','no_kontak','lingkungan','nama_pemilik','photo_path','stts_lembaga','jumlah_siswa'
    ];
}

