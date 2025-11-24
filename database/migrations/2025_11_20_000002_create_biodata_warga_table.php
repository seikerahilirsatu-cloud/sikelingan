<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('biodata_warga', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('family_id')->nullable()->index();
            $table->string('no_kk', 20)->nullable()->index();
            $table->string('nik', 20)->unique();
            $table->string('nama_lgkp', 150);
            $table->enum('jenis_kelamin', ['L','P'])->nullable();
            $table->date('tgl_lhr')->nullable();
            $table->string('agama', 50)->nullable();
            $table->string('pendidikan_terakhir', 100)->nullable();
            $table->string('pekerjaan', 100)->nullable();
            $table->string('stts_kawin', 50)->nullable();
            $table->string('stts_hub_keluarga', 50)->nullable();
            $table->tinyInteger('status_warga')->unsigned()->nullable();
            $table->string('flag_status', 20)->default('Aktif');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('family_id')->references('id')->on('data_keluarga')->onDelete('set null');
            $table->foreign('no_kk')->references('no_kk')->on('data_keluarga')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('biodata_warga');
    }
};
