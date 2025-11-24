<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BiodataWarga extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'biodata_warga';

    protected $fillable = [
        'family_id', 'no_kk', 'lingkungan', 'nik', 'nama_lgkp', 'jenis_kelamin', 'tmpt_lahir', 'tgl_lhr',
        'agama', 'pendidikan_terakhir', 'pekerjaan', 'stts_kawin', 'stts_hub_keluarga',
        'status_warga', 'flag_status', 'alamat', 'created_by', 'updated_by'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if ($model->family_id) {
                $f = DataKeluarga::find($model->family_id);
                if ($f) {
                    // Ensure resident inherits authoritative no_kk and status_warga from family
                    $model->no_kk = $f->no_kk;
                    $model->status_warga = $f->status_keluarga;
                    // Also inherit lingkungan for faster filtering
                    $model->lingkungan = $f->lingkungan;
                    // inherit alamat from family so resident has full address
                    $model->alamat = $f->alamat;
                }
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('family_id')) {
                if ($model->family_id) {
                    $f = DataKeluarga::find($model->family_id);
                    if ($f) {
                        $model->no_kk = $f->no_kk;
                        $model->status_warga = $f->status_keluarga;
                        $model->lingkungan = $f->lingkungan;
                        $model->alamat = $f->alamat;
                    }
                } else {
                    $model->no_kk = null;
                    $model->status_warga = null;
                    $model->lingkungan = null;
                    $model->alamat = null;
                }
            }
        });
    }

    public function family()
    {
        return $this->belongsTo(DataKeluarga::class, 'family_id');
    }
}
