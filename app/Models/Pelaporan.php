<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelaporan extends Model
{
    use HasFactory;

    protected $table = "pelaporans";
    protected $fillable = [
        'user_id',
        'nama_pelapor',
        'melapor_sebagai',
        'nomor_hp',
        'alamat_email',
        'domisili_pelapor',
        'jenis_kekerasan_seksual',
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
        'bukti',
        'voicenote',
    ];
    


    // Jika diperlukan, definisikan relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
