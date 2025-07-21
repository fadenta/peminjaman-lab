<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom penanggung_jawab ke tabel rents
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rents', function (Blueprint $table) {
            $table->string('penanggung_jawab')->nullable()->after('purpose');
        });
    }

    /**
     * Menghapus kolom penanggung_jawab dari tabel rents (rollback)
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rents', function (Blueprint $table) {
            $table->dropColumn('penanggung_jawab');
        });
    }
};
