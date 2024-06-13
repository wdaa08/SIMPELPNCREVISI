<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelaporan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
        // Log::info('Request Data: ', $request->all());
        // Validasi data
        $validate = Validator::make($request->all(), [
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
            'nomor_hp_pihak_lain' => 'nullable|string',
            'kebutuhan_korban' => 'nullable|array',
            'voicenote' => 'required|mimes:audio/wav|max:2048',
        ]);

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        $data = $request->all();  // Ambil semua data request

        if ($request->hasFile('bukti')) {
            $imagePath = $request->file('bukti')->store('bukti');
            $data['bukti'] = $imagePath;  // Tambahkan path bukti ke dalam data yang sudah divalidasi
        }
        if ($request->hasFile('voicenote')) {
            $voicePath = $request->file('voicenote')->store('voicenote');
            $data['voicenote'] = $voicePath;
        }

        // Menggabungkan data inputan yang berupa array menjadi string
        $combineKebutuhan = implode(', ', $request->input('kebutuhan_korban', []));
        $data['kebutuhan_korban'] = $combineKebutuhan;

        // Simpan data ke database
        $pelapor = new Pelaporan;
        $pelapor->nama_pelapor = $data['nama_pelapor'];
        $pelapor->melapor_sebagai = $data['melapor_sebagai'];
        $pelapor->nomor_hp = $data['nomor_hp'];
        $pelapor->alamat_email = $data['alamat_email'];
        $pelapor->domisili_pelapor = $data['domisili_pelapor'];
        $pelapor->jenis_kekerasan_seksual = $data['jenis_kekerasan_seksual'];
        $pelapor->cerita_peristiwa = $data['cerita_peristiwa'];
        $pelapor->memiliki_disabilitas = $data['memiliki_disabilitas'];
        $pelapor->status_terlapor = $data['status_terlapor'];
        $pelapor->alasan_pengaduan = $data['alasan_pengaduan'];
        $pelapor->tanggal_pelaporan = $data['tanggal_pelaporan'];
        $pelapor->nomor_hp_pihak_lain = $data['nomor_hp_pihak_lain'];
        $pelapor->kebutuhan_korban = $data['kebutuhan_korban'];
        $pelapor->bukti = $data['bukti'] ?? null;
        $pelapor->voicenote = $data['voicenote'] ?? null;
        $pelapor->respon = 'TERKIRIM';
        
        // Pastikan field ini ada di form jika diperlukan
        if (isset($data['deskripsi_disabilitas'])) {
            $pelapor->deskripsi_disabilitas = $data['deskripsi_disabilitas'];
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
            'nomor_hp' => 'required|string|max:14',
            'alamat_email' => 'required|email',
            'domisili_pelapor' => 'required|string',
            'jenis_kekerasan_seksual' => 'required|string',
            'cerita_peristiwa' => 'required|string',
            'memiliki_disabilitas' => 'required',
            'status_terlapor' => 'required|string',
            'alasan_pengaduan' => 'required',
            'tanggal_pelaporan' => 'required|date',
            'tanda_tangan_pelapor' => 'nullable|image|mimes:jpeg,png,jpg',
            'nomor_hp_pihak_lain' => 'nullable|string|max:14',
            'kebutuhan_korban' => 'nullable|array',
            'deskripsi_disabilitas' => 'nullable|string',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg',
        ];

        $messages = [
            'nama_pelapor.required' => 'Nama Pelapor tidak boleh kosong!',
            'nomor_hp.max' => 'Nomor HP tidak boleh lebih dari 14 angka!',
            'nomor_hp_pihak_lain.max' => 'Nomor HP pihak lain tidak boleh lebih dari 14 angka!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Menggabungkan data inputan yang berupa array menjadi string
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
        } else {
            $pelapor->deskripsi_disabilitas = null;
        }

        if ($request->hasFile('bukti')) {
            $imagePath = $request->file('bukti')->store('bukti');
            $rules['bukti'] = $imagePath;
        }


        $pelapor->status_terlapor = $request->status_terlapor;
        $pelapor->alasan_pengaduan = $request->alasan_pengaduan;
        $pelapor->nomor_hp_pihak_lain = $request->nomor_hp_pihak_lain;
        $pelapor->kebutuhan_korban = $combineKebutuhan;
        $pelapor->tanggal_pelaporan = $request->tanggal_pelaporan;
        $pelapor->bukti = $request->bukti;


        $pelapor->save();

        return redirect()->route('laporansaya')->with('success', 'Formulir pelaporan berhasil diupdate.');
    }


    public function ttdview($id)
    {
        $pelapor = Pelaporan::findOrFail($id);
        return view('satgas.ttdView', compact('pelapor'));
    }

    public function editdatapelaporan($id)
    {
        $pelapor = Pelaporan::findOrFail($id);
        return view('satgas.editdatapelaporan', compact('pelapor'));
    }

    public function updatedatapelaporan(Request $request, $id)
    {
        $pelapor = Pelaporan::findOrFail($id);

        $request->validate([
            'respon' => 'required|string'
        ]);

        $pelapor->respon = $request->respon;
        $pelapor->save();
        return redirect()->route('s.datapelaporan')->with('success', 'Formulir pelaporan berhasil diupdate.');
    }
}
