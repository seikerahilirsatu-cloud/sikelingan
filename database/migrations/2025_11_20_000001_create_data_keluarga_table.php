<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('data_keluarga', function (Blueprint $table) {
            $table->id();
            $table->string('no_kk', 20)->unique();
            $table->string('nama_kep', 150);
            $table->text('alamat');
            $table->string('lingkungan')->nullable();
            // 1 = Warga Domisili, 2 = Warga Luar Domisili, 3 = Warga Domisili Baru
            $table->tinyInteger('status_keluarga')->unsigned()->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_keluarga');
    }
};
