<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('biodata_warga', function (Blueprint $table) {
            $table->string('lingkungan', 20)->nullable()->after('no_kk')->index();
        });
    }

    public function down()
    {
        Schema::table('biodata_warga', function (Blueprint $table) {
            $table->dropColumn('lingkungan');
        });
    }
};
