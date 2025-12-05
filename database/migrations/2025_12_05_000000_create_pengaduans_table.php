<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tiket')->unique();
            $table->string('nama')->nullable();
            $table->string('kontak')->nullable();
            $table->string('kategori');
            $table->string('judul');
            $table->text('isi');
            $table->string('lokasi')->nullable();
            $table->json('lampiran')->nullable();
            $table->string('status')->default('baru');
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->unsignedBigInteger('handled_by')->nullable();
            $table->text('handled_notes')->nullable();
            $table->timestamp('handled_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};

