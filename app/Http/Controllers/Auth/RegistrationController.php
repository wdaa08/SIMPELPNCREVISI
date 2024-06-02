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
        ]);

        // Simpan pengguna baru ke dalam database
        $user = User::create([
            'nama' => $validatedData['nama'],
            'npm_nidn_npak' => $validatedData['npm_nidn_npak'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

 // Tambahkan pesan flash
 Session::flash('success', 'Pendaftaran berhasil. Silakan masuk dengan akun baru Anda.');

 // Redirect ke halaman login
 return redirect()->route('login');
    }
}
