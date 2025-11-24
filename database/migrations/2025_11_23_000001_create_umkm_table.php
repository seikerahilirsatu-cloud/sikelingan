<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('umkm', function (Blueprint $table) {
            $table->id();
            $table->string('nama_usaha');
            $table->string('jenis')->nullable();
            $table->text('alamat')->nullable();
            $table->string('lingkungan')->nullable();
            $table->string('status_operasional')->nullable();
            $table->string('pemilik_nik')->nullable();
            $table->string('kontak')->nullable();
            $table->date('tanggal_berdiri')->nullable();
            $table->decimal('omzet', 15, 2)->nullable();
            $table->string('koordinat_lat')->nullable();
            $table->string('koordinat_lng')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('npwp_pemilik')->nullable();
            $table->string('no_nib')->nullable();
            $table->timestamps();
        });
        Schema::table('umkm', function (Blueprint $table) {
            $table->index(['nama_usaha']);
            $table->index(['jenis']);
            $table->index(['lingkungan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umkm');
    }
};