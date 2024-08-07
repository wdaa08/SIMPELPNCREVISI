<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Pelaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;


class DashboardSatgasController extends Controller
{
    public function index()
    {
        
        $pelaporans = Pelaporan::orderBy('created_at', 'desc')->paginate(10);
        return view('satgas.datapelaporan', compact('pelaporans'));

        
        
    }

    public function show($id)
    {
        try {
            $pelaporan = Pelaporan::with('user')->findOrFail($id); // Eager load user untuk mengakses tanda tangan

            return view('detail_pelaporan', compact('pelaporan'));
        } catch (\Exception $e) {
            // Tangkap dan log error jika terjadi masalah
            Log::error('Gagal menampilkan detail pelaporan: ' . $e->getMessage());

            // Tampilkan halaman error atau redirect ke halaman lain
            return back()->withError('Gagal menampilkan detail pelaporan.');
        }

    }

    public function updateRespon(Request $request, $id)
    {
        try {
            $pelaporan = Pelaporan::findOrFail($id); // Cari pelaporan berdasarkan ID
            $pelaporan->respon = $request->input('respon'); // Update respon dari request
            $pelaporan->respon_dari = Auth::id(); // Simpan ID pengguna yang memberikan respon terakhir
    
            // Simpan perubahan respon
            $pelaporan->save();
    
            // Ambil data pengguna yang memberikan respon terakhir
            $user = User::findOrFail($pelaporan->respon_dari);
    
            // Tambahkan informasi pengguna yang memberikan respon terakhir ke dalam respons JSON
            $pelaporan->respon_dari_user = $user; // Anda bisa menyesuaikan bagaimana data pengguna disajikan
    
            return response()->json($pelaporan); // Berhasil, kembalikan data pelaporan yang sudah diupdate
        } catch (\Exception $e) {
            // Tangkap dan log error jika terjadi masalah
            Log::error('Gagal memperbarui respon pelaporan: ' . $e->getMessage());
    
            return response()->json(['error' => 'Gagal memperbarui respon pelaporan.'], 500);
        }
    }



    public function dashboard()
    {
        // Mengambil jumlah pengguna
        $jumlahUser = User::count();
    
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
        return view('satgas.dashboard', compact('jumlahUser', 'jumlahLaporan', 'laporanPerJurusan', 'laporanPerProdi', 'laporanPerUnitKerja', 'laporanPerBulan', 'statusTerlapor', 'jenisKekerasanSeksual'));
    }
    
    














    
    
    public function pdf()
    {
        // Mengambil jumlah pengguna
        $jumlahUser = User::count();
    
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
            DB::raw('YEAR(tanggal_pelaporan) as tahun'),
            DB::raw('MONTH(tanggal_pelaporan) as bulan'),
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
    
        // Render HTML view
        $html = view('satgas.dashboard_pdf', compact('jumlahUser', 'jumlahLaporan', 'laporanPerJurusan', 'laporanPerProdi', 'laporanPerUnitKerja', 'laporanPerBulan', 'statusTerlapor', 'jenisKekerasanSeksual'))->render();
    
        // Load HTML into PDF and render it
        $pdf = PDF::loadHTML($html)->setPaper('A4', 'portrait');
    
        // Return PDF sebagai streaming untuk di-download
        return $pdf->stream('dashboard.pdf');
    }
}




