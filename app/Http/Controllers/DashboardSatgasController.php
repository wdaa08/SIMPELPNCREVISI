<?php

namespace App\Http\Controllers;

use App\Models\Pelaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardSatgasController extends Controller
{
    public function index()
    {
        
        $pelaporans = Pelaporan::all(); // Mengambil semua data pelaporan
        return view('satgas.datapelaporan', compact('pelaporans'));
        
    }

    public function show($id)
    {
        $pelaporan = Pelaporan::findOrFail($id);
        return response()->json($pelaporan);

    }

    public function updateRespon(Request $request, $id)
    {
        try {
            $pelaporan = Pelaporan::findOrFail($id); // Cari pelaporan berdasarkan ID
            $pelaporan->respon = $request->input('respon'); // Update respon dari request

            // Simpan perubahan respon
            $pelaporan->save();

            return response()->json($pelaporan); // Berhasil, kembalikan data pelaporan yang sudah diupdate
        } catch (\Exception $e) {
            // Tangkap dan log error jika terjadi masalah
            Log::error('Gagal memperbarui respon pelaporan: ' . $e->getMessage());

            return response()->json(['error' => 'Gaagal memperbarui respon pelaporan.'], 500);
        }
    }

}
