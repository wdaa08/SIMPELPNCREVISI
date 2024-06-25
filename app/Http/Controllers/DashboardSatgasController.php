<?php

namespace App\Http\Controllers;

use App\Models\Pelaporan;
use Illuminate\Http\Request;
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
    
}
