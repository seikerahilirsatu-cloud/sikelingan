<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('pendidikan_non_formal')) {
            Schema::create('pendidikan_non_formal', function (Blueprint $table) {
                $table->id();
                $table->string('nama_lembaga');
                $table->string('bidang_pelatihan')->index();
                $table->integer('tahun_berdiri')->nullable();
                $table->string('sk_pendirian')->nullable();
                $table->text('alamat')->nullable();
                $table->string('no_kontak')->nullable();
                $table->string('lingkungan', 20)->nullable()->index();
                $table->string('nama_pemilik')->nullable();
                $table->string('photo_path')->nullable();
                $table->string('stts_lembaga')->nullable();
                $table->integer('jumlah_siswa')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('pendidikan_non_formal');
    }
};

