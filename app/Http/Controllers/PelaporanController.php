<?php

namespace App\Http\Controllers;


use App\Models\Pelaporan;
use Termwind\Components\Dd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use Illuminate\Console\View\Components\Alert;

class PelaporanController extends Controller
{
    public function index()
    {
        return view('layouts.tampilanpelapor');
    }

    public function store(Request $request)
    {
        // Validasi data
        $validate = Validator::make(
            $request->all(),
            [
                'nama_pelapor' => 'required|string',
                'melapor_sebagai' => 'required',
                'nomor_hp' => 'required|string|max:14',
                'alamat_email' => 'required|email',
                'domisili_pelapor' => 'required|string',
                'jenis_kekerasan_seksual' => 'required|string',
                'cerita_peristiwa' => 'required|string',
                'memiliki_disabilitas' => 'required',
                'deskripsi_disabilitas' => 'nullable|string',
                'status_terlapor' => 'required',
                'alasan_pengaduan' => 'nullable|array',
                'tanggal_pelaporan' => 'required|date',
                'nomor_hp_pihak_lain' => 'nullable|string|max:14',
                'kebutuhan_korban' => 'nullable|array',
                'bukti' => 'nullable|max:2048', // Menambahkan ukuran maksimum file
                'video.*' => 'nullable|max:102400', // Video (mp4, mov, avi) maks 100MB
                'voicenote' => 'nullable|max:10240', // Menambahkan validasi file voicenote
            ],
            [
                'nama_pelapor.required' => 'Nama pelapor tidak boleh kosong.',
                'melapor_sebagai.required' => 'Melapor sebagai tidak boleh kosong.',
                'nomor_hp.required' => 'Nomor HP tidak boleh kosong.',
                'alamat_email.required' => 'Alamat email tidak boleh kosong.',
                'alamat_email.email' => 'Format alamat email tidak valid.',
                'domisili_pelapor.required' => 'Domisili pelapor tidak boleh kosong.',
                'jenis_kekerasan_seksual.required' => 'Jenis kekerasan seksual tidak boleh kosong.',
                'cerita_peristiwa.required' => 'Cerita peristiwa tidak boleh kosong.',
                'memiliki_disabilitas.required' => 'Memiliki disabilitas tidak boleh kosong.',
                'status_terlapor.required' => 'Status terlapor tidak boleh kosong.',
                'tanggal_pelaporan.required' => 'Tanggal pelaporan tidak boleh kosong.',
                'tanggal_pelaporan.date' => 'Format tanggal pelaporan tidak valid.',
            ]
        );

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput()
                ->with('error', 'Mohon isi data yang kosong!');
        }

        $data = $request->all();

        // Debugging: log all request data
        Log::debug('Request data:', $data);

        // Mengelola upload file bukti
        if ($request->hasFile('bukti')) {
            $imagePath = $request->file('bukti')->store('bukti');
            $data['bukti'] = $imagePath;
            Log::info('Bukti path:', ['path' => $imagePath]);
        }

        // Mengelola upload file video
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('video');
            $data['video'] = $videoPath;
            // Simpan path atau lakukan sesuai kebutuhan aplikasi
            Log::info('Video path:', ['path' => $videoPath]);
        }

        // Mengelola upload file voicenote
        if ($request->hasFile('voicenote')) {
            if ($request->file('voicenote')->isValid()) {
                $voicenotePath = $request->file('voicenote')->store('voicenote');
                $data['voicenote'] = $voicenotePath;
                Log::info('Voicenote path:', ['path' => $voicenotePath]);
            } else {
                Log::error('Invalid voicenote file');
            }
        }

        // Menggabungkan data inputan yang berupa array menjadi string
        $data['kebutuhan_korban'] = implode(', ', $request->input('kebutuhan_korban', []));
        $data['alasan_pengaduan'] = implode(', ', $request->input('alasan_pengaduan', []));

        // Debugging: log data before saving
        Log::info('Data before saving:', $data);

        try {
            // Simpan data ke database
            $pelapor = new Pelaporan;
            $pelapor->user_id = Auth::id();
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
            $pelapor->video = $data['video'] ?? null;
            $pelapor->respon = 'TERKIRIM';

            if (isset($data['deskripsi_disabilitas'])) {
                $pelapor->deskripsi_disabilitas = $data['deskripsi_disabilitas'];
            }

            $pelapor->save();

            // Debugging: log after data is saved
            Log::info('Data saved successfully:', $pelapor->toArray());



            // Ambil nomor target dari luar, misalnya dari input atau variabel lain
            $targetNumber = '6287734577740'; // Contoh nomor yang diambil dari luar, bisa disesuaikan dengan kebutuhan aplikasi
            // Mengirim pesan WhatsApp dengan Fonnte
            $client = new Client();
            $apiKey = config('services.fonnte.api_key');
            Log::info('Using Fonnte API Key:', ['apiKey' => $apiKey]); // Logging API key untuk debugging

            $message = "Pelaporan baru dari: " . $data['nama_pelapor'] . "\nJenis Kekerasan Seksual: " . $data['jenis_kekerasan_seksual'];
            $response = $client->post('https://api.fonnte.com/send', [
                'headers' => [
                    'Authorization' => $apiKey,
                ],
                'form_params' => [
                    'target' => $targetNumber,
                    'message' => $message,
                ],
            ]);

            $responseBody = json_decode($response->getBody(), true);
            Log::info('Fonnte API response:', $responseBody);

            if ($responseBody['status'] === false) {
                Log::error('Failed to send WhatsApp message', ['reason' => $responseBody['reason']]);
            } else {
                Log::info('WhatsApp message sent successfully');
            }
        } catch (\Exception $e) {
            // Catch any exceptions and log them
            Log::error('Error saving data:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }

        return redirect()->back()->with('success', 'Alhamdulilah, Formulir pelaporan berhasil Terkirim.');
    }

    




    public function datapelaporan()
    {
        $tabellaporan = Pelaporan::all();
        // dd($tabellaporan);

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
        $userId = Auth::id(); // Mendapatkan ID pengguna yang sedang login
        $tabellaporan = Pelaporan::where('user_id', $userId)->get();
    
        return view('pelapor.laporanSaya', compact('tabellaporan'));
    }
    
    public function editlaporan($id)
    {
        $pelapor = Pelaporan::findOrFail($id);
        $formattedDate = isset($pelapor->tanggal_pelaporan) ? \Carbon\Carbon::parse($pelapor->tanggal_pelaporan)->format('Y-m-d') : '';
        return view('pelapor.edit_laporan', compact('pelapor', 'formattedDate'));
    }
    public function dashboardpelapor()
    {
        return view('pelapor.dashboardpelapor');
    }

    public function updatelaporan(Request $request, $id)
    {
        // Tambahkan log untuk melacak eksekusi fungsi
        Log::info('Memulai fungsi updatelaporan untuk pelapor ID: ' . $id);
    
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
            'bukti' => 'image|file',
            'video.*' => 'nullable|max:102400', // Video (mp4, mov, avi) maks 100MB
            'voicenote' => 'nullable',
        ];
    
        $messages = [
            'nama_pelapor.required' => 'Nama Pelapor tidak boleh kosong!',
            'nomor_hp.max' => 'Nomor HP tidak boleh lebih dari 14 angka!',
            'nomor_hp_pihak_lain.max' => 'Nomor HP pihak lain tidak boleh lebih dari 14 angka!',
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            Log::warning('Validasi gagal untuk pelapor ID: ' . $id, ['errors' => $validator->errors()]);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        // Menggabungkan data inputan yang berupa array menjadi string
        $combineKebutuhan = implode(', ', $request->input('kebutuhan_korban', []));
        $combineAlasan = implode(', ', $request->input('alasan_pengaduan', []));
    
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
    
        $pelapor->status_terlapor = $request->status_terlapor;
        $pelapor->alasan_pengaduan = $combineAlasan;
        $pelapor->nomor_hp_pihak_lain = $request->nomor_hp_pihak_lain;
        $pelapor->kebutuhan_korban = $combineKebutuhan;
        $pelapor->tanggal_pelaporan = $request->tanggal_pelaporan;
    
        // Mengelola upload file bukti
         // Mengelola upload file bukti
         if ($request->hasFile('bukti')) {
            $imagePath = $request->file('bukti')->store('bukti');
            $data['bukti'] = $imagePath;
            Log::info('Bukti path:', ['path' => $imagePath]);
        }
        // Mengelola upload file video
        if ($request->hasFile('video')) {
            $videoFiles = [];
            foreach ($request->file('video') as $file) {
                $path = $file->store('video', 'public');
                $videoFiles[] = $path;
            }
            $pelapor->video = json_encode($videoFiles);
            Log::info('File video baru disimpan: ' . json_encode($videoFiles));
        } else {
            Log::warning('Tidak ada file video dalam request.');
        }
    
        // Mengelola upload file voice note
        if ($request->hasFile('voicenote')) {
            Log::info('Ada file voice note baru yang diunggah oleh pelapor dengan ID: ' . $pelapor->id);
    
            // Hapus file voice note lama jika ada
            if ($pelapor->voicenote) {
                Log::info('Menghapus file voice note lama: ' . $pelapor->voicenote);
                Storage::delete($pelapor->voicenote);
            }
    
            // Simpan file voice note baru
            $filePath = $request->file('voicenote')->store('voicenotes', 'public');
            $pelapor->voicenote = $filePath;
            Log::info('File voice note baru disimpan: ' . $filePath);
        } else {
            Log::warning('Tidak ada file voicenote dalam request.');
        }
    
        $pelapor->save();
    
        Log::info('Pelapor ID: ' . $pelapor->id . ' berhasil diupdate.');
    
        return redirect()->route('laporansaya')->with('edit.success', 'Formulir pelaporan berhasil diupdate.');
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

    // Method untuk mengupdate respon pelaporan
    public function updateRespon(Request $request, $id)
    {
        // Validasi request jika diperlukan
        $request->validate([
            'respon' => 'required|string',
        ]);

        $user = auth()->user();

        // Cari pelaporan berdasarkan ID
        $pelaporan = Pelaporan::findOrFail($id);

        // Update respon dan simpan ID pengguna
        $pelaporan->respon = $request->respon;
        $pelaporan->respon_dari = $user->id; // Menyimpan ID pengguna yang memberikan respon
        $pelaporan->save();

        // Mengembalikan data yang diperbarui dalam format JSON
        return response()->json([
            'respon' => $pelaporan->respon,
            'user_nama' => $user->nama // Mengembalikan nama pengguna
        ]);
    }
    public function laporanSelesai(Request $request, $id)
    {
        try {
            $pelaporan = Pelaporan::findOrFail($id);
            $pelaporan->selesai = 'selesai'; // Set nilai string untuk menandai selesai
            $pelaporan->save();
    
            Log::info('Laporan berhasil ditandai selesai: ' . $pelaporan->id);
            return redirect()->back()->with('successstatus', 'Laporan berhasil ditandai selesai.');
        } catch (\Exception $e) {
            Log::error('Gagal menandai laporan selesai: ' . $e->getMessage());
            return redirect()->back()->with('errorstatus', 'Terjadi kesalahan saat menandai laporan sebagai selesai.');
        }
    }
    



    public function show($id)
    {
        $pelaporan = Pelaporan::find($id);
        return response()->json($pelaporan);
    }
}
