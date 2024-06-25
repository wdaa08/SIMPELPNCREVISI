<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelaporansTable extends Migration
{
    public function up()
    {
        Schema::create('pelaporans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nama_pelapor');
            $table->string('melapor_sebagai');
            $table->string('nomor_hp');
            $table->string('alamat_email');
            $table->string('domisili_pelapor');
            $table->string('jenis_kekerasan_seksual');
            $table->text('cerita_peristiwa');
            $table->string('memiliki_disabilitas');
            $table->string('deskripsi_disabilitas')->nullable();
            $table->string('status_terlapor');
            $table->text('alasan_pengaduan');
            $table->string('nomor_hp_pihak_lain')->nullable();
            $table->text('kebutuhan_korban')->nullable();
            $table->date('tanggal_pelaporan');
            $table->string('bukti')->nullable();
            $table->string('voicenote')->nullable();
            $table->string('respon')->default('TERKIRIM');
            $table->unsignedBigInteger('respon_dari')->nullable();
            $table->foreign('respon_dari')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelaporans');
    }
}
