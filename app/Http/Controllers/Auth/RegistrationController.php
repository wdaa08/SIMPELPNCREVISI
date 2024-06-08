<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class RegistrationController extends Controller
{
    public function create()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            
            'nama' => 'required|string|max:255',
            'npm_nidn_npak' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
            'tanda_tangan' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        dd($validatedData);

        if ($request->hasFile('tanda_tangan')) {
            $imagePath = $request->file('tanda_tangan')->store('tanda_tangan'); // Menyimpan gambar ke direktori yang diinginkan
        } else {
            $imagePath = null; // Atur path gambar menjadi null jika tidak ada gambar yang diunggah
        }

        // Simpan pengguna baru ke dalam database
        $user = User::create([
            'nama' => $validatedData['nama'],
            'npm_nidn_npak' => $validatedData['npm_nidn_npak'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'tanda_tangan' => $imagePath, // Menyimpan path gambar ke dalam kolom 'tanda_tangan'
        ]);

        if ($user) {
            // Tambahkan pesan flash sukses
            Session::flash('success', 'Pendaftaran berhasil. Silakan masuk dengan akun baru Anda.');

            // Redirect ke halaman login jika sukses
            return redirect()->route('login');
        } else {
            // Tambahkan pesan flash gagal
            Session::flash('error', 'Gagal menyimpan data pengguna. Silakan coba lagi.');

            // Redirect kembali ke halaman pendaftaran jika gagal
            return redirect()->back()->withInput();
        }
    }
}