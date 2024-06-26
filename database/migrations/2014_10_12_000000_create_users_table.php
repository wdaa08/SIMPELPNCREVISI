<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id')->default(2); // Contoh nilai default, sesuaikan sesuai dengan logika bisnis Anda
            $table->string('nama');
            $table->string('npm_nidn_npak')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('tanda_tangan')->nullable();
            $table->string('jabatan')->nullable(); // New field
            $table->string('unit_kerja')->nullable(); // New field
            $table->string('prodi')->nullable(); // New field
            $table->string('jurusan')->nullable(); // New field
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('role_id')->references('id')->on('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
