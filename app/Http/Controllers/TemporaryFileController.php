<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemporaryFileController extends Controller
{
    public function handleTemporaryFile(Request $request)
    {
        // Ambil file sementara
        $temporaryFile = 'C:\xampp\tmp\php53AA.tmp';

        // Simpan file sementara ke dalam direktori storage Laravel
        if (Storage::put('temporary_files/' . basename($temporaryFile), file_get_contents($temporaryFile))) {
            // Jika berhasil, hapus file sementara dari tempat asalnya
            unlink($temporaryFile);
            return response()->json(['message' => 'File sementara berhasil disimpan di storage Laravel.']);
        } else {
            return response()->json(['message' => 'Gagal menyimpan file sementara di storage Laravel.']);
        }
    }
}
