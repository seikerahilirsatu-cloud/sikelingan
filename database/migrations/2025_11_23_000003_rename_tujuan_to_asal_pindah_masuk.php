<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('pindah_masuk')) {
            Schema::table('pindah_masuk', function (Blueprint $table) {
                if (! Schema::hasColumn('pindah_masuk', 'asal')) {
                    $table->text('asal')->nullable()->after('tanggal_masuk');
                }
            });

            if (Schema::hasColumn('pindah_masuk', 'tujuan')) {
                DB::table('pindah_masuk')->whereNotNull('tujuan')->update(['asal' => DB::raw('tujuan')]);
            }

            Schema::table('pindah_masuk', function (Blueprint $table) {
                if (Schema::hasColumn('pindah_masuk', 'tujuan')) {
                    $table->dropColumn('tujuan');
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('pindah_masuk')) {
            Schema::table('pindah_masuk', function (Blueprint $table) {
                if (! Schema::hasColumn('pindah_masuk', 'tujuan')) {
                    $table->text('tujuan')->nullable()->after('tanggal_masuk');
                }
            });

            if (Schema::hasColumn('pindah_masuk', 'asal')) {
                DB::table('pindah_masuk')->whereNotNull('asal')->update(['tujuan' => DB::raw('asal')]);
            }

            Schema::table('pindah_masuk', function (Blueprint $table) {
                if (Schema::hasColumn('pindah_masuk', 'asal')) {
                    $table->dropColumn('asal');
                }
            });
        }
    }
};
