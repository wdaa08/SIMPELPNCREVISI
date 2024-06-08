<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function datapengguna(){
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

              
        $user = User::findOrFail($id);

        // dd($request->file('tanda_tangan'));
   

        // Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'npm_nidn_npak' => 'required|string|max:255|unique:users,npm_nidn_npak,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'tanda_tangan' => 'image|file|max:5000' ,
        ]);

        if($request->file('tanda_tangan')) {
            $validatedData['tanda_tangan'] = $request->file('tanda_tangan')->store('profile');
        }




        // if ($request->hasFile('tanda_tangan')) {
        //     // Hapus tanda tangan lama jika ada
        //     if ($user->tanda_tangan) {
        //         Storage::delete('public/tanda_tangan/' . $user->tanda_tangan);
        //     }
        //     // Simpan tanda tangan baru
        //     $imagePath = $request->file('tanda_tangan')->store('images');
        //     $user->tanda_tangan = $imagePath;
        // }
    

        // Update data pengguna
        $user->update($validatedData);

        // Mengembalikan tampilan profil dengan data yang telah diperbarui
        return view('profile', compact('user'))->with('success', 'Profile updated successfully');
    }

}
