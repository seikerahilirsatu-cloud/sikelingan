<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('data_keluarga', function (Blueprint $table) {
            if (!Schema::hasColumn('data_keluarga', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('status_keluarga');
                $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            }
        });

        Schema::table('biodata_warga', function (Blueprint $table) {
            if (!Schema::hasColumn('biodata_warga', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('flag_status');
                $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            }
        });
    }

    public function down()
    {
        Schema::table('data_keluarga', function (Blueprint $table) {
            $table->dropColumn(['created_by', 'updated_by']);
        });

        Schema::table('biodata_warga', function (Blueprint $table) {
            $table->dropColumn(['created_by', 'updated_by']);
        });
    }
};
