<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('warga_meninggal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('warga_id');
            $table->unsignedBigInteger('family_id')->nullable();
            $table->string('lingkungan')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_kk')->nullable();
            $table->date('tanggal_meninggal')->nullable();
            $table->time('waktu_meninggal')->nullable();
            $table->string('tempat_meninggal')->nullable();
            $table->date('tanggal_dikebumikan')->nullable();
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('warga_id')->references('id')->on('biodata_warga')->onDelete('cascade');
            $table->foreign('family_id')->references('id')->on('data_keluarga')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('warga_meninggal');
    }
};
