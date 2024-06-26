<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function datapengguna()
    {
        $tabelpengguna = User::all();
        return view('satgas.datapengguna', compact('tabelpengguna'));
    }

    public function profile($id)
    {
        $user = User::findOrFail($id);
        return view('profile', compact('user'));
    }

    

    public function updateprofile(Request $request, $id)
    {
        // Menemukan data pengguna berdasarkan ID
        $user = User::findOrFail($id);
    
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'npm_nidn_npak' => 'required|string|max:255|unique:users,npm_nidn_npak,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'tanda_tangan' => 'image|max:5000',
        ]);
    
        // Jika validasi gagal, kembalikan dengan pesan kesalahan
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
    
        // Inisialisasi $validatedData
        $validatedData = $validator->validated();
    
        // Jika file tanda tangan diunggah, simpan dan atur ke validatedData
        if ($request->hasFile('tanda_tangan')) {
            $validatedData['tanda_tangan'] = $request->file('tanda_tangan')->store('profile');
            
            // Hapus file lama jika ada
            if ($user->tanda_tangan) {
                Storage::delete($user->tanda_tangan);
            }
        }
    
        // Update data pengguna dengan data yang divalidasi
        $user->update($validatedData);
    
        // Redirect ke halaman profil dengan pesan sukses
        return redirect()->route('profile', ['id' => $id])->with('edit.success', 'Profil berhasil diperbarui.');
    }
    

    public function showImportForm()
    {
        return view('users.import'); // Buat view untuk menampilkan formulir import
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls', // Validasi untuk tipe file Excel
        ]);

        Excel::import(new UsersImport, $request->file('file')); // Proses import menggunakan kelas UsersImport

        return redirect()->route('datapengguna')->with('success', 'Pengguna berhasil diimpor.'); // Redirect ke halaman setelah import selesai
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'npm_nidn_npak' => 'required|string|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'jabatan' => 'nullable|string',
            'unit_kerja' => 'nullable|string',
            'prodi' => 'nullable|string',
            'jurusan' => 'nullable|string',
        ]);
    
        Log::info('Validated Data:', $validatedData); // Logging for debugging
    
        User::create([
            'nama' => $validatedData['nama'],
            'npm_nidn_npak' => $validatedData['npm_nidn_npak'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'jabatan' => $validatedData['jabatan'],
            'unit_kerja' => $validatedData['unit_kerja'],
            'prodi' => $validatedData['prodi'],
            'jurusan' => $validatedData['jurusan'],
        ]);
    
        return redirect()->route('s.datapengguna')->with('success', 'Pengguna berhasil ditambahkan.');
    }
    


}
