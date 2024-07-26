<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pelaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DirekturController extends Controller
{
    public function index()
    {
        $pelaporans = Pelaporan::orderBy('created_at', 'desc')->paginate(10);
        return view('direktur.dashboarddirektur', compact('pelaporans'));
    }
    public function datalaporanmasuk()
    {
          
        // Mengambil jumlah laporan
        $jumlahLaporan = Pelaporan::count();
    
        // Mengambil jumlah laporan per jurusan
        $laporanPerJurusan = Pelaporan::join('users', 'pelaporans.user_id', '=', 'users.id')
            ->select('users.jurusan as jurusan', DB::raw('count(*) as total'))
            ->groupBy('users.jurusan')
            ->get();
    
        // Mengambil jumlah laporan per prodi
        $laporanPerProdi = Pelaporan::join('users', 'pelaporans.user_id', '=', 'users.id')
            ->select('users.prodi as prodi', DB::raw('count(*) as total'))
            ->groupBy('users.prodi')
            ->get();
    
        // Mengambil jumlah laporan per unit kerja
        $laporanPerUnitKerja = Pelaporan::join('users', 'pelaporans.user_id', '=', 'users.id')
            ->select('users.unit_kerja as unit_kerja', DB::raw('count(*) as total'))
            ->groupBy('users.unit_kerja')
            ->get();
    
        // Mengambil jumlah laporan per bulan dan tahun berdasarkan kolom tanggal_pelaporan
        $laporanPerBulan = Pelaporan::select(
            DB::raw('YEAR(tanggal_pelaporan) as tahun'), // Ubah sesuai dengan nama kolom yang sesuai
            DB::raw('MONTH(tanggal_pelaporan) as bulan'), // Ubah sesuai dengan nama kolom yang sesuai
            DB::raw('count(*) as total'),
            DB::raw('sum(IF(selesai = "selesai", 1, 0)) as selesai_count'),
            DB::raw('sum(IF(selesai = "belum", 1, 0)) as belum_count')
        )
        ->groupBy('tahun', 'bulan')
        ->get();
    
        // Mengambil status_terlapor beserta jumlahnya
        $statusTerlapor = Pelaporan::select('status_terlapor', DB::raw('count(*) as total'))
            ->groupBy('status_terlapor')
            ->get();
    
        // Mengambil jenis kekerasan seksual beserta jumlahnya
        $jenisKekerasanSeksual = Pelaporan::select('jenis_kekerasan_seksual', DB::raw('count(*) as total'))
            ->groupBy('jenis_kekerasan_seksual')
            ->get();
    
        // Meneruskan data ke tampilan
        return view('direktur.datalaporanmasuk', compact('jumlahLaporan', 'laporanPerJurusan', 'laporanPerProdi', 'laporanPerUnitKerja', 'laporanPerBulan', 'statusTerlapor', 'jenisKekerasanSeksual'));
    }
}
