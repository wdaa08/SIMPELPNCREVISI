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
            'nomorhp' => 'nullable|string',
            'domisili' => 'nullable|string',
            'prodi' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'unit_kerja' => 'nullable|string|max:255',
            'tanda_tangan' => 'image|max:5000',
            'current_password' => 'nullable|string', // Validasi untuk password saat ini
            'password' => 'nullable|string|min:8|confirmed', // Validasi untuk password baru
        ], [
            'nama.required' => 'Nama tidak boleh kosong.',
            'npm_nidn_npak.required' => 'NPM/NIDN/NPAK tidak boleh kosong.',
            'email.required' => 'Email tidak boleh kosong.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);


    
        // Jika validasi gagal, kembalikan dengan pesan kesalahan
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
    
        // Verifikasi password saat ini jika password baru diisi
        if ($request->filled('password') && !Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Password saat ini tidak cocok.'])->withInput();
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
    
        // Update password jika ada input password baru yang dikonfirmasi
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->input('password'));
        } else {
            // Hapus validasi password dari $validatedData agar tidak mengubah password
            unset($validatedData['password']);
        }
    
    // Update data pengguna dengan data yang divalidasi
    try {
        $user->update($validatedData);
    } catch (\Exception $e) {
        return redirect()->back()->with('edit.error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
    }

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

        return redirect()->route('s.datapengguna')->with('success', 'Pengguna berhasil diimpor.'); // Redirect ke halaman setelah import selesai
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function deleteUsersByYear(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year' => 'required|integer|min:1900|max:' . date('Y'),
        ], [
            'year.required' => 'Tahun tidak boleh kosong.',
            'year.integer' => 'Tahun harus berupa angka.',
            'year.min' => 'Tahun tidak valid.',
            'year.max' => 'Tahun tidak valid.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $year = $request->input('year');
    
        $users = User::whereYear('created_at', $year)->where('role_id', '<>', 1)->get();
    
        $skippedUsers = [];
    
        foreach ($users as $user) {
            $pendingReports = $user->pelaporans()->where('selesai', 0)->exists();
    
            if ($pendingReports) {
                $skippedUsers[] = $user->nama; // Simpan nama pengguna yang dilewati
                continue;
            }
    
            try {
                $user->delete();
            } catch (\Exception $e) {
                Log::error('Error deleting user:', ['error' => $e->getMessage()]);
                return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data pengguna. Silakan coba lagi.');
            }
        }
    
        if (count($skippedUsers) > 0) {
            $skippedUsersList = implode(', ', $skippedUsers);
            $warningMessage = "Beberapa pengguna tidak dapat dihapus karena memiliki pelaporan yang belum selesai: $skippedUsersList";
        
            // Tambahkan kondisi jika yang kosong adalah role_id 2
            if (empty($skippedUsers) && $request->role_id == 2) {
                $warningMessage = "Tidak ada pengguna dengan role_id 2 pada tahun ini.";
            }
        
            return redirect()->route('s.datapengguna')->with('warning', $warningMessage);
        }
        
    
        return redirect()->route('s.datapengguna')->with('successhapusdata', 'Pengguna berhasil dihapus.');
    }
    






    
    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'npm_nidn_npak' => 'required|string|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'nomorhp' =>'nullable|string',
            'domisili' => 'nullable|string',
            'password' => 'required|string',
            'jabatan' => 'nullable|string',
            'unit_kerja' => 'nullable|string',
            'prodi' => 'nullable|string',
            'jurusan' => 'nullable|string',
            'role_id' => 'required', // Pastikan input role_id valid dan ada di tabel roles
        ], [
            'nama.required' => 'Nama tidak boleh kosong.',
            'npm_nidn_npak.required' => 'NPM/NIDN/NPAK tidak boleh kosong.',
            'email.required' => 'Email tidak boleh kosong.',
            'password.required' => 'Password tidak boleh kosong.',
            'role_id.required' => 'Role harus dipilih.',
            'role_id.exists' => 'Role yang dipilih tidak valid.',
        ]);
    
        // Logging untuk debug
        Log::info('Validated Data:', $validatedData);
    
        try {
            // Simpan data pengguna ke database
            $user = User::create([
                'nama' => $validatedData['nama'],
                'npm_nidn_npak' => $validatedData['npm_nidn_npak'],
                'email' => $validatedData['email'],
                'nomorhp' => $validatedData['nomorhp'],
                'domisili' => $validatedData['domisili'],
                'password' => Hash::make($validatedData['password']),
                'jabatan' => $validatedData['jabatan'],
                'unit_kerja' => $validatedData['unit_kerja'],
                'prodi' => $validatedData['prodi'],
                'jurusan' => $validatedData['jurusan'],
                'role_id' => $validatedData['role_id'], // Simpan role_id dari form ke dalam kolom role_id di tabel users
            ]);
    
            // Redirect dengan pesan sukses jika berhasil
            return redirect()->route('s.datapengguna')->with('success', 'Pengguna berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Tangkap error jika terjadi dan log pesan error
            Log::error('Error saving user data:', ['errortambah1data' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data pengguna. Silakan coba lagi.');
        }
    }
    

}
