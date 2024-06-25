<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResponDariToPelaporansTable extends Migration
{
    public function up()
    {
        Schema::table('pelaporans', function (Blueprint $table) {
            $table->unsignedBigInteger('respon_dari')->nullable(); // Kolom respon_dari, bisa null
            // Jika ingin terhubung dengan tabel pengguna, Anda bisa menambahkan foreign key constraint
            $table->foreign('respon_dari')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('pelaporans', function (Blueprint $table) {
            $table->dropColumn('respon_dari');
        });
    }
}
