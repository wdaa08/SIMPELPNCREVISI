?<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVideoToPelaporansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pelaporans', function (Blueprint $table) {
            $table->string('video')->nullable()->after('bukti'); // Menambahkan kolom video setelah kolom bukti
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pelaporans', function (Blueprint $table) {
            $table->dropColumn('video'); // Menghapus kolom video jika rollback migrasi
        });
    }
}
