<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // If the table has the old columns, create new ones, copy values and drop old ones.
        if (Schema::hasTable('pindah_masuk')) {
            // add new columns if not exists
            Schema::table('pindah_masuk', function (Blueprint $table) {
                if (! Schema::hasColumn('pindah_masuk', 'tanggal_masuk')) {
                    $table->date('tanggal_masuk')->nullable()->after('no_kk');
                }
                if (! Schema::hasColumn('pindah_masuk', 'jenis_masuk')) {
                    $table->string('jenis_masuk')->nullable()->after('tujuan');
                }
            });

            // copy data from old columns if they exist
            if (Schema::hasColumn('pindah_masuk', 'tanggal_pindah')) {
                DB::table('pindah_masuk')->whereNotNull('tanggal_pindah')->update(['tanggal_masuk' => DB::raw('tanggal_pindah')]);
            }
            if (Schema::hasColumn('pindah_masuk', 'jenis_pindah')) {
                DB::table('pindah_masuk')->whereNotNull('jenis_pindah')->update(['jenis_masuk' => DB::raw('jenis_pindah')]);
            }

            // drop old columns if present
            Schema::table('pindah_masuk', function (Blueprint $table) {
                if (Schema::hasColumn('pindah_masuk', 'tanggal_pindah')) {
                    $table->dropColumn('tanggal_pindah');
                }
                if (Schema::hasColumn('pindah_masuk', 'jenis_pindah')) {
                    $table->dropColumn('jenis_pindah');
                }
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
        if (Schema::hasTable('pindah_masuk')) {
            Schema::table('pindah_masuk', function (Blueprint $table) {
                if (! Schema::hasColumn('pindah_masuk', 'tanggal_pindah')) {
                    $table->date('tanggal_pindah')->nullable()->after('no_kk');
                }
                if (! Schema::hasColumn('pindah_masuk', 'jenis_pindah')) {
                    $table->string('jenis_pindah')->nullable()->after('tujuan');
                }
            });

            if (Schema::hasColumn('pindah_masuk', 'tanggal_masuk')) {
                DB::table('pindah_masuk')->whereNotNull('tanggal_masuk')->update(['tanggal_pindah' => DB::raw('tanggal_masuk')]);
            }
            if (Schema::hasColumn('pindah_masuk', 'jenis_masuk')) {
                DB::table('pindah_masuk')->whereNotNull('jenis_masuk')->update(['jenis_pindah' => DB::raw('jenis_masuk')]);
            }

            Schema::table('pindah_masuk', function (Blueprint $table) {
                if (Schema::hasColumn('pindah_masuk', 'tanggal_masuk')) {
                    $table->dropColumn('tanggal_masuk');
                }
                if (Schema::hasColumn('pindah_masuk', 'jenis_masuk')) {
                    $table->dropColumn('jenis_masuk');
                }
            });
        }
    }
};
