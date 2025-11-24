<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('warga_meninggal', function (Blueprint $table) {
            // add sebab_meninggal after tempat_meninggal for clarity
            $table->text('sebab_meninggal')->nullable()->after('tempat_meninggal');
        });
    }

    public function down()
    {
        Schema::table('warga_meninggal', function (Blueprint $table) {
            $table->dropColumn('sebab_meninggal');
        });
    }
};
