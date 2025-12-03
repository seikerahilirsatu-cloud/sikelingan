<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('pendidikan_formal')) {
            Schema::create('pendidikan_formal', function (Blueprint $table) {
                $table->id();
                $table->string('nama_sekolah');
                $table->string('jenjang')->index();
                $table->string('jenis_sekolah')->nullable();
                $table->integer('tahun_berdiri')->nullable();
                $table->string('sk_pendirian')->nullable();
                $table->text('alamat')->nullable();
                $table->string('lingkungan', 20)->nullable()->index();
                $table->string('photo_path')->nullable();
                $table->string('stts_sekolah')->nullable();
                $table->integer('jlh_ruang_kelas')->nullable();
                $table->integer('jlh_perpustakaan')->nullable();
                $table->integer('jlh_lab')->nullable();
                $table->integer('jlh_wc')->nullable();
                $table->string('kantin')->nullable();
                $table->string('nama_kep_sekolah')->nullable();
                $table->integer('jlh_guru_pegawai')->nullable();
                $table->integer('jlh_guru_honor')->nullable();
                $table->integer('jumlah_siswa')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('pendidikan_formal');
    }
};

