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
            $table->string('nama_pelapor');
            $table->enum('melapor_sebagai', ['korban', 'saksi']);
            $table->string('nomor_hp');
            $table->string('alamat_email');
            $table->string('domisili_pelapor');
            $table->text('jenis_kekerasan_seksual');
            $table->text('cerita_peristiwa');
            $table->enum('memiliki_disabilitas', ['memiliki', 'tidak']);
            $table->text('deskripsi_disabilitas')->nullable();
            $table->enum('status_terlapor', ['Mahasiswa', 'Pendidik', 'Tenaga Kependidikan', 'Warga Kampus', 'Masyarakat Umum']);
            $table->text('alasan_pengaduan');
            $table->string('nomor_hp_pihak_lain')->nullable();
            $table->text('kebutuhan_korban')->nullable();
            $table->date('tanggal_pelaporan');
            $table->string('tanda_tangan_pelapor')->nullable(); // Untuk menyimpan path tanda tangan jika diunggah ke server
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelaporans');
    }
}
