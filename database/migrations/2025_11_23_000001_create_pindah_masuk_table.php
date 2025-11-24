<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('pindah_masuk')) {
            Schema::create('pindah_masuk', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('warga_id')->nullable()->index();
                $table->unsignedBigInteger('family_id')->nullable()->index();
                $table->string('no_kk')->nullable();
                $table->date('tanggal_pindah');
                $table->text('tujuan')->nullable();
                $table->string('jenis_pindah')->nullable();
                $table->text('keterangan')->nullable();
                $table->string('lingkungan')->nullable()->index();
                $table->text('alamat')->nullable();
                $table->unsignedBigInteger('created_by')->nullable()->index();
                $table->timestamps();

                // foreign keys are optional (depending on existing DB), avoid strict constraints here
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pindah_masuk');
    }
};
