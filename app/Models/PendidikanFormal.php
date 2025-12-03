<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PendidikanFormal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pendidikan_formal';

    protected $fillable = [
        'nama_sekolah','jenjang','jenis_sekolah','tahun_berdiri','sk_pendirian','alamat','lingkungan','photo_path','stts_sekolah','jlh_ruang_kelas','jlh_perpustakaan','jlh_lab','jlh_wc','kantin','nama_kep_sekolah','jlh_guru_pegawai','jlh_guru_honor','jumlah_siswa'
    ];
}

