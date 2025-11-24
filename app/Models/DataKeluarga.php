<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataKeluarga extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'data_keluarga';

    protected $fillable = [
        'no_kk', 'nama_kep', 'alamat', 'lingkungan', 'status_keluarga', 'created_by', 'updated_by'
    ];

    public function members()
    {
        return $this->hasMany(BiodataWarga::class, 'family_id');
    }
}
