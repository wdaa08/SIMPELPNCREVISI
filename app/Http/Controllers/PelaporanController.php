<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelaporan;
use Illuminate\Support\Facades\Validator;
use Termwind\Components\Dd;

class PelaporanController extends Controller
{
    public function index()
    {
        return view('layouts.tampilanpelapor');
    }

    public function store(Request $request)
    {
        // Validasi data
        $rules = [
            'nama_pelapor' => 'required|string',
            'melapor_sebagai' => 'required',
            'nomor_hp' => 'required|string',
            'alamat_email' => 'required|email',
            'domisili_pelapor' => 'required|string',
            'jenis_kekerasan_seksual' => 'required|string',
            'cerita_peristiwa' => 'required|string',
            'memiliki_disabilitas' => 'required',
            'status_terlapor' => 'required',
            'alasan_pengaduan' => 'required',
            'tanggal_pelaporan' => 'required|date',
            'tanda_tangan_pelapor' => 'nullable||image|mimes:jpeg,png,jpg',
            'nomor_hp_pihak_lain' => 'nullable|string',
            'kebutuhan_korban' => 'nullable',
        ];

        $messages = [
            'nama_pelapor.required' => 'Nama Pelapor tidak boleh kosong!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        // Menggabungkan data inputan yang berupa array menjadi string
        $combineAlasan = implode(', ', $request->input('alasan_pengaduan', []));
        $combineKebutuhan = implode(', ', $request->input('kebutuhan_korban', []));

        $pelapor = new Pelaporan;
        $pelapor->nama_pelapor = $request->nama_pelapor;
        $pelapor->melapor_sebagai = $request->melapor_sebagai;
        $pelapor->nomor_hp = $request->nomor_hp;
        $pelapor->alamat_email = $request->alamat_email;
        $pelapor->domisili_pelapor = $request->domisili_pelapor;
        $pelapor->jenis_kekerasan_seksual = $request->jenis_kekerasan_seksual;
        $pelapor->cerita_peristiwa = $request->cerita_peristiwa;
        $pelapor->memiliki_disabilitas = $request->memiliki_disabilitas;

        if ($request->memiliki_disabilitas == 'memiliki') {
            $pelapor->deskripsi_disabilitas = $request->deskripsi_disabilitas;
        }

        $pelapor->status_terlapor = $request->status_terlapor;
        $pelapor->alasan_pengaduan = $combineAlasan;
        $pelapor->nomor_hp_pihak_lain = $request->nomor_hp_pihak_lain;
        $pelapor->kebutuhan_korban = $combineKebutuhan;
        $pelapor->tanggal_pelaporan = $request->tanggal_pelaporan;
        // $pelapor->tanda_tangan_pelapor = $request->tanda_tangan_pelapor;

        if ($request->hasFile('tanda_tangan_pelapor')) {
            $imagePath = $request->file('tanda_tangan_pelapor')->store('images');
            $pelapor->tanda_tangan_pelapor = $imagePath;
            
        }

        $pelapor->save();

        return redirect()->back()->with('success', 'Formulir pelaporan berhasil disimpan.');
    }

    public function datapelaporan()
    {
        $tabellaporan = Pelaporan::all();
        return view('satgas.datapelaporan', compact('tabellaporan'));
    }

    public function search(Request $request)
    {
        if ($request->has('search')) {
            $tabellaporan = Pelaporan::where('melapor_sebagai', 'LIKE', '%' . $request->search . '%')->get();
        } else {
            $tabellaporan = Pelaporan::all();
        }

        if ($request->ajax()) {
            $view = view('satgas.partial_datapelaporan', compact('tabellaporan'))->render();
            return response()->json($view);
        }

        return view('satgas.datapelaporan', ['tabellaporan' => $tabellaporan]);
    }

    public function pelaporan()
    {
        return view('pelapor.pelaporan');
    }
    public function laporansaya()
    {
        $tabellaporan = Pelaporan::all();
        return view('pelapor.laporanSaya', compact('tabellaporan'));
    }
    public function editlaporan($id)
    {
        $pelapor = Pelaporan::findOrFail($id);
        $pelapor->alasan_pengaduan = json_decode($pelapor->alasan_pengaduan, true); // Pastikan ini adalah array
        $formattedDate = isset($pelapor->tanggal_pelaporan) ? \Carbon\Carbon::parse($pelapor->tanggal_pelaporan)->format('Y-m-d') : '';
        return view('pelapor.edit_laporan', compact('pelapor', 'formattedDate'));
    }

    public function updatelaporan(Request $request, $id)
    {
        $pelapor = Pelaporan::findOrFail($id);

        // Validasi data
        $rules = [
            'nama_pelapor' => 'required|string',
            'melapor_sebagai' => 'required',
            'nomor_hp' => 'required|string',
            'alamat_email' => 'required|email',
            'domisili_pelapor' => 'required|string',
            'jenis_kekerasan_seksual' => 'required|string',
            'cerita_peristiwa' => 'required|string',
            'memiliki_disabilitas' => 'required',
            'status_terlapor' => 'required',
            'alasan_pengaduan' => 'required',
            'tanggal_pelaporan' => 'required|date',
            'tanda_tangan_pelapor' => 'nullable|image|mimes:jpeg,png,jpg',
            'nomor_hp_pihak_lain' => 'nullable|string',
            'kebutuhan_korban' => 'nullable',
        ];

        $messages = [
            'nama_pelapor.required' => 'Nama Pelapor tidak boleh kosong!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Menggabungkan data inputan yang berupa array menjadi string
        $combineAlasan = implode(', ', $request->input('alasan_pengaduan', []));
        $combineKebutuhan = implode(', ', $request->input('kebutuhan_korban', []));

        // Update data pelapor
        $pelapor->nama_pelapor = $request->nama_pelapor;
        $pelapor->melapor_sebagai = $request->melapor_sebagai;
        $pelapor->nomor_hp = $request->nomor_hp;
        $pelapor->alamat_email = $request->alamat_email;
        $pelapor->domisili_pelapor = $request->domisili_pelapor;
        $pelapor->jenis_kekerasan_seksual = $request->jenis_kekerasan_seksual;
        $pelapor->cerita_peristiwa = $request->cerita_peristiwa;
        $pelapor->memiliki_disabilitas = $request->memiliki_disabilitas;

        if ($request->memiliki_disabilitas == 'memiliki') {
            $pelapor->deskripsi_disabilitas = $request->deskripsi_disabilitas;
        }

        $pelapor->status_terlapor = $request->status_terlapor;
        $pelapor->alasan_pengaduan = $combineAlasan;
        $pelapor->nomor_hp_pihak_lain = $request->nomor_hp_pihak_lain;
        $pelapor->kebutuhan_korban = $combineKebutuhan;
        $pelapor->tanggal_pelaporan = $request->tanggal_pelaporan;

        // Mengunggah dan menyimpan path tanda tangan pelapor jika ada
        if ($request->hasFile('tanda_tangan_pelapor')) {
            $imagePath = $request->file('tanda_tangan_pelapor')->store('images');
            $pelapor->tanda_tangan_pelapor = $imagePath;
        }

        $pelapor->save();

        return redirect()->route('laporansaya')->with('success', 'Formulir pelaporan berhasil diupdate.');
    }

    public function ttdview($id)
    {
        $pelapor = Pelaporan::findOrFail($id);
        return view('satgas.ttdView', compact('pelapor'));
    }
}
