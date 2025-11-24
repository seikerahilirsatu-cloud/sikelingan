<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasColumn('biodata_warga', 'alamat')) {
            Schema::table('biodata_warga', function (Blueprint $table) {
                $table->text('alamat')->nullable()->after('no_kk');
                // do not add an index here to avoid duplicate-index errors on systems
                // where an index on `no_kk` already exists
            });
        }

        if (! Schema::hasColumn('pindah_keluar', 'alamat')) {
            Schema::table('pindah_keluar', function (Blueprint $table) {
                $table->text('alamat')->nullable()->after('lingkungan');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('biodata_warga', 'alamat')) {
            Schema::table('biodata_warga', function (Blueprint $table) {
                // avoid dropping indexes that may be managed by other migrations
                $table->dropColumn('alamat');
            });
        }

        if (Schema::hasColumn('pindah_keluar', 'alamat')) {
            Schema::table('pindah_keluar', function (Blueprint $table) {
                $table->dropColumn('alamat');
            });
        }
    }
};
