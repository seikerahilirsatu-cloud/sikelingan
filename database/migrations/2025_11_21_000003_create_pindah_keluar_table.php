<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('pindah_keluar')) {
            Schema::create('pindah_keluar', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('warga_id')->nullable();
                $table->unsignedBigInteger('family_id')->nullable();
                $table->string('lingkungan')->nullable();
                $table->text('alamat')->nullable();
                $table->string('no_kk')->nullable();
                $table->date('tanggal_pindah')->nullable();
                $table->string('tujuan', 500)->nullable();
                $table->string('jenis_pindah')->nullable();
                $table->text('keterangan')->nullable();
                $table->unsignedBigInteger('created_by')->nullable();
                $table->timestamps();

                $table->index(['warga_id']);
                $table->index(['family_id']);
                $table->index(['lingkungan']);
                $table->index(['tanggal_pindah']);
                $table->index(['no_kk']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pindah_keluar');
    }
};
