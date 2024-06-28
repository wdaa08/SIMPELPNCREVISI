<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSelesaiColumnToPelaporansTable extends Migration
{
    public function up()
    {
        Schema::table('pelaporans', function (Blueprint $table) {
            $table->string('selesai')->default('belum'); // Tambahkan kolom selesai dengan tipe string dan nilai default 'belum'
        });
    }

    public function down()
    {
        Schema::table('pelaporans', function (Blueprint $table) {
            $table->dropColumn('selesai');
        });
    }
}
