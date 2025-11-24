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
        if (! Schema::hasColumn('pindah_keluar', 'lingkungan')) {
            Schema::table('pindah_keluar', function (Blueprint $table) {
                $table->string('lingkungan')->nullable()->after('family_id');
                $table->index('lingkungan');
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
        if (Schema::hasColumn('pindah_keluar', 'lingkungan')) {
            Schema::table('pindah_keluar', function (Blueprint $table) {
                $table->dropIndex(['lingkungan']);
                $table->dropColumn('lingkungan');
            });
        }
    }
};
