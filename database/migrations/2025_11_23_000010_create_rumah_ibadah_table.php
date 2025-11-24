<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rumah_ibadah', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->string('jenis', 20);
            $table->text('alamat');
            $table->string('lingkungan')->nullable()->index();
            $table->string('status_operasional', 20)->default('Aktif')->index();
            $table->integer('kapasitas')->unsigned()->nullable();
            $table->date('tanggal_berdiri')->nullable();
            $table->string('pengurus_nik', 20)->nullable()->index();
            $table->string('kontak', 100)->nullable();
            $table->decimal('koordinat_lat', 10, 7)->nullable();
            $table->decimal('koordinat_lng', 10, 7)->nullable();
            $table->string('photo_path', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['nama','alamat']);
            $table->foreign('pengurus_nik')->references('nik')->on('biodata_warga')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rumah_ibadah');
    }
};