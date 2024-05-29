<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelaporan extends Model
{
    use HasFactory;

    protected $table = "pelaporans";
    protected $fillable = [
        'namapelapor',
        'melaporsebagai',
        'nomorhp',
        'alamatemailpelapor',
        'domisilipelapor',
        'jenis_kekerasan',
        'cerita_peristiwa',
        'memiliki_disabilitas',
        'deskripsi_disabilitas',
        'status_terlapor',
        'alasan_pengaduan',
        'nomor_hp_pihak_lain',
        'kebutuhan_korban',
        'tanggal_pelaporan',
        'tanda_tangan_pelapor',
        'respon',
    ];
}
